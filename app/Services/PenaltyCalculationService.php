<?php

namespace App\Services;

use App\Models\Container;
use Carbon\Carbon;

class PenaltyCalculationService
{
    /**
     * Calculate delivery penalty based on exit_date and container type
     *
     * Delivery full 40ft:
     * - Masa 1: Rp.15.125 (hari 1-5 flat rate) beban ke Pelayaran
     * - Masa 1.2: Rp.15.125/hari (hari 6-10, mulai hitung dari hari ke-6) beban ke JPT
     * - Masa 2: Rp.30.250/hari (hari 11+, mulai hitung dari hari ke-11) beban ke JPT
     *
     * Delivery full 20ft:
     * - Masa 1: Rp.7600 (hari 1-5 flat rate) beban ke Pelayaran
     * - Masa 1.2: Rp.7.600/hari (hari 6-10, mulai hitung dari hari ke-6) beban ke JPT
     * - Masa 2: Rp.15.200/hari (hari 11+, mulai hitung dari hari ke-11) beban ke JPT
     */
    public static function calculateDeliveryPenalty(Container $container): array
    {
        // Jika tidak ada exit_date, tidak ada denda
        if (!$container->exit_date) {
            return [
                'total_amount' => 0,
                'penalty_days' => 0,
                'responsible_party' => null,
                'breakdown' => [],
                'description' => 'Tidak ada tanggal keluar'
            ];
        }

        $exitDate = Carbon::parse($container->exit_date)->startOfDay();
        $today = now()->startOfDay();

        // Jika belum melewati tanggal keluar, tidak ada denda
        if ($today <= $exitDate) {
            return [
                'total_amount' => 0,
                'penalty_days' => 0,
                'responsible_party' => null,
                'breakdown' => [],
                'description' => 'Belum melewati tanggal keluar'
            ];
        }

        $penaltyDays = $exitDate->diffInDays($today);
        $containerType = $container->type ?? '20ft';

        // Set tarif berdasarkan type container
        if ($containerType === '40ft') {
            $masa1Rate = 15125;    // Rp.15.125
            $masa12Rate = 15125;   // Rp.15.125/hari
            $masa2Rate = 30250;    // Rp.30.250/hari
        } else { // 20ft
            $masa1Rate = 7600;     // Rp.7600
            $masa12Rate = 7600;    // Rp.7.600/hari
            $masa2Rate = 15200;    // Rp.15.200/hari
        }

        $totalAmount = 0;
        $breakdown = [];
        $responsibleParty = null;

        if ($penaltyDays <= 5) {
            // Masa 1: Hari 1-5 (flat rate, beban ke Pelayaran)
            $totalAmount = $masa1Rate;
            $responsibleParty = 'Pelayaran';
            $breakdown[] = [
                'period' => 'Masa 1 (Hari 1-5)',
                'days' => $penaltyDays,
                'rate' => $masa1Rate,
                'amount' => $masa1Rate,
                'responsible' => 'Pelayaran',
                'note' => 'Flat rate untuk masa 1'
            ];
        } elseif ($penaltyDays <= 10) {
            // Masa 1 + Masa 1.2: Flat rate masa 1 + hitung per hari mulai hari ke-6 (beban ke JPT)
            $masa1Amount = $masa1Rate;
            $masa12Days = $penaltyDays - 5; // Hari di masa 1.2 (mulai dari hari ke-6)
            $masa12Amount = $masa12Days * $masa12Rate;
            $totalAmount = $masa1Amount + $masa12Amount;
            $responsibleParty = 'JPT';

            $breakdown[] = [
                'period' => 'Masa 1 (Hari 1-5)',
                'days' => 5,
                'rate' => $masa1Rate,
                'amount' => $masa1Amount,
                'responsible' => 'Pelayaran',
                'note' => 'Flat rate untuk masa 1'
            ];
            $breakdown[] = [
                'period' => 'Masa 1.2 (Hari 6-10)',
                'days' => $masa12Days,
                'rate' => $masa12Rate,
                'amount' => $masa12Amount,
                'responsible' => 'JPT',
                'note' => 'Per hari mulai hari ke-6'
            ];
        } else {
            // Masa 1 + Masa 1.2 + Masa 2: Flat rate masa 1 + masa 1.2 (5 hari) + hitung per hari mulai hari ke-11 (beban ke JPT)
            $masa1Amount = $masa1Rate;
            $masa12Amount = 5 * $masa12Rate; // 5 hari masa 1.2 (hari 6-10)
            $masa2Days = $penaltyDays - 10; // Hari di masa 2 (mulai dari hari ke-11)
            $masa2Amount = $masa2Days * $masa2Rate;
            $totalAmount = $masa1Amount + $masa12Amount + $masa2Amount;
            $responsibleParty = 'JPT';

            $breakdown[] = [
                'period' => 'Masa 1 (Hari 1-5)',
                'days' => 5,
                'rate' => $masa1Rate,
                'amount' => $masa1Amount,
                'responsible' => 'Pelayaran',
                'note' => 'Flat rate untuk masa 1'
            ];
            $breakdown[] = [
                'period' => 'Masa 1.2 (Hari 6-10)',
                'days' => 5,
                'rate' => $masa12Rate,
                'amount' => $masa12Amount,
                'responsible' => 'JPT',
                'note' => 'Per hari untuk hari 6-10'
            ];
            $breakdown[] = [
                'period' => 'Masa 2 (Hari 11+)',
                'days' => $masa2Days,
                'rate' => $masa2Rate,
                'amount' => $masa2Amount,
                'responsible' => 'JPT',
                'note' => 'Per hari mulai hari ke-11'
            ];
        }

        return [
            'total_amount' => $totalAmount,
            'penalty_days' => $penaltyDays,
            'responsible_party' => $responsibleParty,
            'breakdown' => $breakdown,
            'description' => self::generateDeliveryPenaltyDescription($penaltyDays, $containerType, $totalAmount)
        ];
    }

    /**
     * Calculate delivery penalty for current period only (non-cumulative)
     * Menghitung denda hanya untuk periode saat ini, bukan akumulatif
     */
    public static function calculateCurrentPeriodPenalty(Container $container): array
    {
        // Jika tidak ada exit_date, tidak ada denda
        if (!$container->exit_date) {
            return [
                'current_amount' => 0,
                'penalty_days' => 0,
                'current_period' => null,
                'current_responsible' => null,
                'current_rate' => 0,
                'description' => 'Tidak ada tanggal keluar'
            ];
        }

        $exitDate = Carbon::parse($container->exit_date)->startOfDay();
        $today = now()->startOfDay();

        // Jika belum melewati tanggal keluar, tidak ada denda
        if ($today <= $exitDate) {
            return [
                'current_amount' => 0,
                'penalty_days' => 0,
                'current_period' => null,
                'current_responsible' => null,
                'current_rate' => 0,
                'description' => 'Belum melewati tanggal keluar'
            ];
        }

        $penaltyDays = $exitDate->diffInDays($today);
        $containerType = $container->type ?? '20ft';  // Jika type tidak ada, default ke 20ft

        // Set tarif berdasarkan type container
        if ($containerType === '40ft') {
            $masa1Rate = 15125;    // Rp.15.125
            $masa12Rate = 15125;   // Rp.15.125/hari
            $masa2Rate = 30250;    // Rp.30.250/hari
        } else { // 20ft
            $masa1Rate = 7600;     // Rp.7600
            $masa12Rate = 7600;    // Rp.7.600/hari
            $masa2Rate = 15200;    // Rp.15.200/hari
        }

        // Inisialisasi variabel untuk periode saat ini
        $currentAmount = 0;
        $currentPeriod = '';
        $currentResponsible = '';
        $currentRate = 0;

        if ($penaltyDays <= 5) {
            // Masa 1: Hari 1-5 (flat rate, beban ke Pelayaran)
            // Tampilkan total denda untuk masa 1 (flat rate)
            $currentAmount = $masa1Rate;
            $currentPeriod = 'Masa 1 (Hari 1-5)';
            $currentResponsible = 'Pelayaran';
            $currentRate = $masa1Rate;
        } elseif ($penaltyDays <= 10) {
            // Masa 1.2: Hari 6-10 (per hari, beban ke JPT)
            // Tampilkan total denda untuk masa 1.2 saja (hari 6 sampai hari ke-X)
            $masa12Days = $penaltyDays - 5; // Hari di masa 1.2 (mulai dari hari ke-6)
            $currentAmount = $masa12Days * $masa12Rate;
            $currentPeriod = "Masa 1.2 (Hari 6-{$penaltyDays})";
            $currentResponsible = 'JPT';
            $currentRate = $masa12Rate;
        } else {
            // Masa 2: Hari 11+ (per hari, beban ke JPT)
            // Tampilkan total denda untuk masa 2 saja (hari 11 sampai hari ke-X)
            $masa2Days = $penaltyDays - 10; // Hari di masa 2 (mulai dari hari ke-11)
            $currentAmount = $masa2Days * $masa2Rate;
            $currentPeriod = "Masa 2 (Hari 11-{$penaltyDays})";
            $currentResponsible = 'JPT';
            $currentRate = $masa2Rate;
        }

        return [
            'current_amount' => $currentAmount,
            'penalty_days' => $penaltyDays,
            'current_period' => $currentPeriod,
            'current_responsible' => $currentResponsible,
            'current_rate' => $currentRate,
            'description' => self::generateCurrentPeriodPenaltyDescription($penaltyDays, $containerType, $currentAmount, $currentPeriod)
        ];
    }
    /**
     * Generate current period penalty description
     */
    private static function generateCurrentPeriodPenaltyDescription($penaltyDays, $containerType, $currentAmount, $currentPeriod): string
    {
        $formattedAmount = 'Rp ' . number_format($currentAmount, 0, ',', '.');

        if ($penaltyDays <= 5) {
            // Masa 1 adalah flat rate
            return "Denda {$containerType}: {$currentPeriod} = {$formattedAmount} (total untuk masa ini)";
        } elseif ($penaltyDays <= 10) {
            // Masa 1.2
            $masa12Days = $penaltyDays - 5;
            $dailyRate = 'Rp ' . number_format($currentAmount / $masa12Days, 0, ',', '.');
            return "Denda {$containerType}: {$currentPeriod} = {$masa12Days} hari × {$dailyRate} = {$formattedAmount}";
        } else {
            // Masa 2
            $masa2Days = $penaltyDays - 10;
            $dailyRate = 'Rp ' . number_format($currentAmount / $masa2Days, 0, ',', '.');
            return "Denda {$containerType}: {$currentPeriod} = {$masa2Days} hari × {$dailyRate} = {$formattedAmount}";
        }
    }

    /**
     * Generate delivery penalty description
     */
    private static function generateDeliveryPenaltyDescription($penaltyDays, $containerType, $totalAmount): string
    {
        $formattedAmount = 'Rp ' . number_format($totalAmount, 0, ',', '.');

        if ($penaltyDays <= 5) {
            return "Denda delivery {$containerType}: Masa 1 ({$penaltyDays} hari) = {$formattedAmount} (flat rate, beban Pelayaran)";
        } elseif ($penaltyDays <= 10) {
            $masa12Days = $penaltyDays - 5;
            return "Denda delivery {$containerType}: Masa 1 (5 hari flat) + Masa 1.2 ({$masa12Days} hari x tarif) = {$formattedAmount} (beban JPT)";
        } else {
            $masa2Days = $penaltyDays - 10;
            return "Denda delivery {$containerType}: Masa 1 (flat) + Masa 1.2 (5 hari) + Masa 2 ({$masa2Days} hari x tarif) = {$formattedAmount} (beban JPT)";
        }
    }

    /**
     * Update container penalty automatically
     */
    public static function updateContainerPenalty(Container $container): array
    {
        $currentPenalty = self::calculateCurrentPeriodPenalty($container);

        $container->update([
            'penalty_status' => $currentPenalty['current_amount'] > 0,
            'penalty_amount' => $currentPenalty['current_amount'],
            'penalty_notes' => $currentPenalty['description'],
        ]);

        return $currentPenalty;
    }

    /**
     * Get penalty days from exit_date
     */
    public static function getPenaltyDays(Container $container): int
    {
        if (!$container->exit_date) {
            return 0;
        }

        $exitDate = Carbon::parse($container->exit_date)->startOfDay();
        $today = now()->startOfDay();

        if ($today <= $exitDate) {
            return 0;
        }

        return $exitDate->diffInDays($today);
    }

    /**
     * Format penalty amount to Indonesian Rupiah
     */
    public static function formatAmount($amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Get penalty rates based on container type
     */
    public static function getPenaltyRates(string $containerType): array
    {
        if ($containerType === '40ft') {
            return [
                'masa1' => 15125,
                'masa12' => 15125,
                'masa2' => 30250,
            ];
        } else { // 20ft
            return [
                'masa1' => 7600,
                'masa12' => 7600,
                'masa2' => 15200,
            ];
        }
    }
}
