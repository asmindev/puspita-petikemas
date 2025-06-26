<?php

namespace App\Services;

use App\Models\Container;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class QueueService
{
    /**
     * Algoritma FCFS + Priority Scheduler
     * Priority: High > Medium > Normal
     * Dalam setiap level priority, gunakan FCFS (First Come First Serve)
     */
    public function processNext(): ?Container
    {
        // Ambil kontainer berikutnya berdasarkan algoritma FCFS + Priority
        $nextContainer = $this->getNextContainer();

        if (!$nextContainer) {
            return null;
        }

        // Update status menjadi processing
        $nextContainer->update([
            'status' => 'processing',
            'waktu_mulai_proses' => now(),
            'queue_position' => null // Keluar dari antrian
        ]);

        return $nextContainer;
    }

    /**
     * Ambil kontainer berikutnya berdasarkan algoritma FCFS + Priority
     */
    public function getNextContainer(): ?Container
    {
        return Container::where('status', 'waiting')
            ->orderByRaw("
                CASE priority
                    WHEN 'Darurat' THEN 1
                    WHEN 'Tinggi' THEN 2
                    WHEN 'Normal' THEN 3
                    ELSE 4
                END ASC
            ")
            ->orderBy('tanggal_masuk', 'asc') // FCFS dalam setiap priority
            ->first();
    }

    /**
     * Selesaikan pemrosesan kontainer
     */
    public function completeProcessing(Container $container): bool
    {
        if ($container->status !== 'processing') {
            return false;
        }

        $container->update([
            'status' => 'completed',
            'waktu_selesai_proses' => now()
        ]);

        return true;
    }

    /**
     * Ambil antrian yang telah diurutkan berdasarkan algoritma
     */
    public function getQueue(): Collection
    {
        return Container::where('status', 'waiting')
            ->with('customer')
            ->orderByRaw("
                CASE priority
                    WHEN 'Darurat' THEN 1
                    WHEN 'Tinggi' THEN 2
                    WHEN 'Normal' THEN 3
                    ELSE 4
                END ASC
            ")
            ->orderBy('tanggal_masuk', 'asc')
            ->get()
            ->map(function ($container, $index) {
                $container->queue_position = $index + 1;
                return $container;
            });
    }

    /**
     * Ambil kontainer yang sedang diproses
     */
    public function getProcessingContainers(): Collection
    {
        return Container::where('status', 'processing')
            ->with('customer')
            ->get()
            ->map(function ($container) {
                if ($container->waktu_mulai_proses) {
                    $elapsed = $container->waktu_mulai_proses->diffInMinutes(now());
                    $container->elapsed_time = $elapsed;
                    $container->progress_percentage = $container->processing_time > 0
                        ? min(100, ($elapsed / $container->processing_time) * 100)
                        : 0;
                }
                return $container;
            });
    }

    /**
     * Ambil statistik antrian
     */
    public function getStatistics(): array
    {
        $waiting = Container::where('status', 'waiting')->count();
        $processing = Container::where('status', 'processing')->count();
        $completed = Container::where('status', 'completed')->count();

        $completedToday = Container::where('status', 'completed')
            ->whereDate('waktu_selesai_proses', today())
            ->count();

        $avgProcessingTime = Container::where('status', 'completed')
            ->whereNotNull('waktu_selesai_proses')
            ->whereNotNull('waktu_mulai_proses')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, waktu_mulai_proses, waktu_selesai_proses)) as avg_time')
            ->value('avg_time') ?? 0;

        return [
            'waiting' => $waiting,
            'processing' => $processing,
            'completed' => $completed,
            'total' => $waiting + $processing + $completed,
            'completed_today' => $completedToday,
            'avg_processing_time' => round($avgProcessingTime, 1)
        ];
    }

    /**
     * Ambil analisis antrian berdasarkan priority
     */
    public function getQueueAnalysis(): array
    {
        $queue = $this->getQueue();

        return [
            'total_waiting' => $queue->count(),
            'high_priority' => $queue->where('priority', 'Darurat')->count(),
            'medium_priority' => $queue->where('priority', 'Tinggi')->count(),
            'normal_priority' => $queue->where('priority', 'Normal')->count(),
            'estimated_wait_time' => $this->calculateEstimatedWaitTime($queue)
        ];
    }

    /**
     * Hitung estimasi waktu tunggu
     */
    private function calculateEstimatedWaitTime(Collection $queue): array
    {
        $currentProcessing = $this->getProcessingContainers();
        $avgProcessingTime = $this->getStatistics()['avg_processing_time'] ?: 30; // Default 30 menit

        $estimates = [];
        $cumulativeTime = 0;

        // Tambahkan waktu sisa untuk kontainer yang sedang diproses
        foreach ($currentProcessing as $container) {
            $remaining = max(0, $container->processing_time - ($container->elapsed_time ?? 0));
            $cumulativeTime += $remaining;
        }

        foreach ($queue as $container) {
            $estimates[$container->id] = [
                'position' => $container->queue_position,
                'estimated_wait_minutes' => round($cumulativeTime),
                'estimated_start_time' => now()->addMinutes($cumulativeTime)->format('H:i')
            ];
            $cumulativeTime += $avgProcessingTime;
        }

        return $estimates;
    }
}
