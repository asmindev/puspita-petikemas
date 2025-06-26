<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'container_number',
        'customer', // Customer name
        'customer_id', // Foreign key to users table
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'waktu_estimasi',
        'priority', // Sekarang enum: Normal, Tinggi, Darurat
        'status_denda',
        'jumlah_denda',
        'keterangan',
        'queue_position',
        'waktu_mulai_proses',
        'waktu_selesai_proses',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime',
        'waktu_mulai_proses' => 'datetime',
        'waktu_selesai_proses' => 'datetime',
        'status_denda' => 'boolean',
        'jumlah_denda' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the container
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Scope for containers in queue (waiting or processing)
     */
    public function scopeInQueue($query)
    {
        return $query->whereIn('status', ['waiting', 'processing']);
    }

    /**
     * Scope for waiting containers
     */
    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    /**
     * Scope for processing containers
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope for completed containers
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get containers ordered by FCFS (First Come First Serve)
     */
    public function scopeFcfsOrder($query)
    {
        return $query->orderBy('tanggal_masuk', 'asc');
    }

    /**
     * Get containers ordered by priority (highest priority first, then FCFS)
     */
    public function scopePriorityOrder($query)
    {
        // Priority order: Darurat > Tinggi > Normal
        $priorityOrder = "CASE
            WHEN priority = 'Darurat' THEN 1
            WHEN priority = 'Tinggi' THEN 2
            WHEN priority = 'Normal' THEN 3
            ELSE 4
        END";

        return $query->orderByRaw($priorityOrder)
            ->orderBy('tanggal_masuk', 'asc');
    }

    /**
     * Calculate waiting time in minutes
     */
    public function getWaitingTimeAttribute()
    {
        if ($this->status === 'waiting') {
            return $this->tanggal_masuk->diffInMinutes(now());
        }

        if ($this->waktu_mulai_proses) {
            return $this->tanggal_masuk->diffInMinutes($this->waktu_mulai_proses);
        }

        return 0;
    }

    /**
     * Calculate processing time in minutes
     */
    public function getProcessingTimeAttribute()
    {
        if ($this->status === 'processing' && $this->waktu_mulai_proses) {
            return $this->waktu_mulai_proses->diffInMinutes(now());
        }

        if ($this->waktu_mulai_proses && $this->waktu_selesai_proses) {
            return $this->waktu_mulai_proses->diffInMinutes($this->waktu_selesai_proses);
        }

        return 0;
    }

    /**
     * Get total time from entry to completion
     */
    public function getTotalTimeAttribute()
    {
        if ($this->waktu_selesai_proses) {
            return $this->tanggal_masuk->diffInMinutes($this->waktu_selesai_proses);
        }

        if ($this->status === 'processing' && $this->waktu_mulai_proses) {
            return $this->tanggal_masuk->diffInMinutes(now());
        }

        return $this->waiting_time;
    }

    /**
     * Calculate storage duration in days (for display - minimum 1 day)
     */
    public function getStorageDurationAttribute()
    {
        $actualDuration = 0;

        if ($this->status === 'completed' && $this->tanggal_keluar) {
            // Gunakan diffInDays dengan true parameter untuk mendapatkan absolute value
            $actualDuration = ceil($this->tanggal_masuk->diffInDays($this->tanggal_keluar, false));
        } else {
            // Hitung dari tanggal masuk sampai hari ini
            $actualDuration = ceil($this->tanggal_masuk->diffInDays(now(), false));
        }

        // Minimum tampilkan 1 hari, dan pastikan selalu integer
        return max(1, (int) $actualDuration);
    }

    /**
     * Calculate penalty days based on scheduled exit date
     */
    public function getPenaltyDaysAttribute()
    {
        // Hanya hitung denda jika status masih waiting dan ada tanggal_keluar yang dijadwalkan
        if ($this->status !== 'waiting' || !$this->tanggal_keluar) {
            return 0;
        }

        // Hitung berapa hari terlambat dari tanggal keluar yang dijadwalkan
        $scheduledExit = $this->tanggal_keluar;
        $today = now()->startOfDay();
        $scheduledExitDay = $scheduledExit->startOfDay();

        // Jika belum melewati tanggal keluar, tidak ada denda
        if ($today <= $scheduledExitDay) {
            return 0;
        }

        // Hitung berapa hari terlambat
        return $scheduledExitDay->diffInDays($today);
    }

    /**
     * Get actual storage duration for general calculation
     */
    public function getActualStorageDurationAttribute()
    {
        if ($this->status === 'completed' && $this->tanggal_keluar) {
            return $this->tanggal_masuk->diffInDays($this->tanggal_keluar);
        }

        return $this->tanggal_masuk->diffInDays(now());
    }

    /**
     * Calculate automatic penalty based on penalty days (days over scheduled exit)
     */
    public function getCalculatedPenaltyAttribute()
    {
        $penaltyDays = $this->penalty_days;

        // Tidak ada denda jika tidak terlambat
        if ($penaltyDays <= 0) {
            return 0;
        }

        $penalty = 0;

        // Hari ke-1,2,3 keterlambatan: Rp 10,000 per hari
        if ($penaltyDays <= 3) {
            $penalty = $penaltyDays * 10000;
        } else {
            // 3 hari pertama: 3 × Rp 10,000 = Rp 30,000
            $penalty = 3 * 10000;

            // Hari ke-4 dst keterlambatan: (penaltyDays - 3) × Rp 15,000
            $penalty += ($penaltyDays - 3) * 15000;
        }

        return $penalty;
    }

    /**
     * Update penalty automatically based on storage duration
     */
    public function updateAutomaticPenalty()
    {
        $calculatedPenalty = $this->calculated_penalty;

        if ($calculatedPenalty > 0) {
            $this->update([
                'status_denda' => true,
                'jumlah_denda' => $calculatedPenalty,
                'keterangan' => $this->generatePenaltyDescription(),
            ]);
        } else {
            $this->update([
                'status_denda' => false,
                'jumlah_denda' => 0,
                'keterangan' => null,
            ]);
        }
    }

    /**
     * Generate penalty description based on penalty days (days over scheduled exit)
     */
    private function generatePenaltyDescription()
    {
        $penaltyDays = $this->penalty_days;

        if ($penaltyDays <= 0) {
            return null;
        }

        if ($penaltyDays <= 3) {
            return "Denda keterlambatan {$penaltyDays} hari × Rp 10.000 = Rp " . number_format($penaltyDays * 10000, 0, ',', '.');
        } else {
            $firstThreeDays = 3 * 10000;
            $additionalDays = $penaltyDays - 3;
            $additionalPenalty = $additionalDays * 15000;
            $total = $firstThreeDays + $additionalPenalty;

            return "Denda keterlambatan: 3 hari pertama (Rp 30.000) + {$additionalDays} hari tambahan × Rp 15.000 = Rp " . number_format($total, 0, ',', '.');
        }
    }

    /**
     * Check if container has penalty
     */
    public function hasPenalty()
    {
        return $this->status_denda && $this->jumlah_denda > 0;
    }

    /**
     * Start processing this container
     */
    public function startProcessing()
    {
        $this->update([
            'status' => 'processing',
            'waktu_mulai_proses' => now(),
        ]);
    }

    /**
     * Complete processing this container
     */
    public function completeProcessing()
    {
        $this->update([
            'status' => 'completed',
            'waktu_selesai_proses' => now(),
            'tanggal_keluar' => now(),
        ]);
    }

    /**
     * Cancel this container
     */
    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'keterangan' => $reason,
        ]);
    }

    /**
     * Get priority level as number for sorting
     */
    public function getPriorityLevelAttribute()
    {
        return match ($this->priority) {
            'Darurat' => 3,
            'Tinggi' => 2,
            'Normal' => 1,
            default => 0,
        };
    }

    /**
     * Get available priority options
     */
    public static function getPriorityOptions()
    {
        return [
            'Normal' => 'Normal',
            'Tinggi' => 'Tinggi',
            'Darurat' => 'Darurat',
        ];
    }
}
