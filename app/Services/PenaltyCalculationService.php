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
     * - Masa 1: Rp.15.125 (hari 1-5 dihitung 1 masa) beban ke Pelayaran
     * - Masa 1.2: Rp.15.125/hari (hari 6-10, hitung hanya hari lebih dari 5) beban ke JPT
     * - Masa 2: Rp.30.250/hari (hari 11+, hitung hanya hari lebih dari 10) beban ke JPT
     *
     * Delivery full 20ft:
     * - Masa 1: Rp.7600 (hari 1-5 dihitung 1 masa) beban ke Pelayaran
     * - Masa 1.2: Rp.7.600/hari (hari 6-10, hitung hanya hari lebih dari 5) beban ke JPT
     * - Masa 2: Rp.15.200/hari (hari 11+, hitung hanya hari lebih dari 10) beban ke JPT
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
            // Masa 1: Hari 1-5 (beban ke Pelayaran)
            $totalAmount = $masa1Rate;
            $responsibleParty = 'Pelayaran';
            $breakdown[] = [
                'period' => 'Masa 1 (Hari 1-5)',
                'days' => $penaltyDays,
                'rate' => $masa1Rate,
                'amount' => $masa1Rate,
                'responsible' => 'Pelayaran',
                'note' => 'Dihitung 1 masa untuk hari 1-5'
            ];
        } elseif ($penaltyDays <= 10) {
            // Masa 1.2: Hitung semua hari terlambat dengan tarif masa 1.2 (beban ke JPT)
            $totalAmount = $penaltyDays * $masa12Rate;
            $responsibleParty = 'JPT';
            $breakdown[] = [
                'period' => 'Masa 1.2 (Hari 6-10)',
                'days' => $penaltyDays,
                'rate' => $masa12Rate,
                'amount' => $totalAmount,
                'responsible' => 'JPT',
                'note' => 'Per hari untuk semua hari terlambat'
            ];
        } else {
            // Masa 2: Hitung semua hari terlambat dengan tarif masa 2 (beban ke JPT)
            $totalAmount = $penaltyDays * $masa2Rate;
            $responsibleParty = 'JPT';
            $breakdown[] = [
                'period' => 'Masa 2 (Hari 11+)',
                'days' => $penaltyDays,
                'rate' => $masa2Rate,
                'amount' => $totalAmount,
                'responsible' => 'JPT',
                'note' => 'Per hari untuk semua hari terlambat'
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
     * Generate delivery penalty description
     */
    private static function generateDeliveryPenaltyDescription($penaltyDays, $containerType, $totalAmount): string
    {
        $formattedAmount = 'Rp ' . number_format($totalAmount, 0, ',', '.');

        if ($penaltyDays <= 5) {
            return "Denda delivery {$containerType}: Masa 1 ({$penaltyDays} hari) = {$formattedAmount} (beban Pelayaran)";
        } elseif ($penaltyDays <= 10) {
            return "Denda delivery {$containerType}: Masa 1.2 ({$penaltyDays} hari) = {$formattedAmount} (beban JPT)";
        } else {
            return "Denda delivery {$containerType}: Masa 2 ({$penaltyDays} hari) = {$formattedAmount} (beban JPT)";
        }
    }

    /**
     * Update container penalty automatically
     */
    public static function updateContainerPenalty(Container $container): array
    {
        $deliveryPenalty = self::calculateDeliveryPenalty($container);

        $container->update([
            'penalty_status' => $deliveryPenalty['total_amount'] > 0,
            'penalty_amount' => $deliveryPenalty['total_amount'],
            'penalty_notes' => $deliveryPenalty['description'],
        ]);

        return $deliveryPenalty;
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
