<?php

require_once __DIR__ . '/vendor/autoload.php';

// Test penalty calculation - Total untuk masa saat ini saja
echo "Testing penalty calculation - Total untuk masa saat ini saja...\n\n";

// Test 1: 3 days late (Masa 1)
$days = 3;
$containerType = '20ft';
$masa1Rate = 7600;
echo "Test 1: {$days} days late ({$containerType})\n";
echo "Masa 1 (Hari 1-3): Flat rate = Rp " . number_format($masa1Rate, 0, ',', '.') . "\n";
echo "Total denda masa ini: Rp " . number_format($masa1Rate, 0, ',', '.') . "\n\n";

// Test 2: 7 days late (Masa 1.2)
$days = 7;
$masa12Rate = 7600;
$masa12Days = $days - 5; // 2 hari di masa 1.2
$masa12Total = $masa12Days * $masa12Rate;
echo "Test 2: {$days} days late ({$containerType})\n";
echo "Masa 1.2 (Hari 6-7): {$masa12Days} hari × Rp " . number_format($masa12Rate, 0, ',', '.') . " = Rp " . number_format($masa12Total, 0, ',', '.') . "\n";
echo "Total denda masa ini: Rp " . number_format($masa12Total, 0, ',', '.') . "\n\n";

// Test 3: 15 days late (Masa 2)
$days = 15;
$masa2Rate = 15200;
$masa2Days = $days - 10; // 5 hari di masa 2
$masa2Total = $masa2Days * $masa2Rate;
echo "Test 3: {$days} days late ({$containerType})\n";
echo "Masa 2 (Hari 11-15): {$masa2Days} hari × Rp " . number_format($masa2Rate, 0, ',', '.') . " = Rp " . number_format($masa2Total, 0, ',', '.') . "\n";
echo "Total denda masa ini: Rp " . number_format($masa2Total, 0, ',', '.') . "\n\n";

echo "PENTING:\n";
echo "- Tidak menampilkan total akumulatif dari semua masa\n";
echo "- Hanya menampilkan total denda untuk masa/periode saat ini\n";
echo "- Misal 15 hari terlambat: hanya tampilkan masa 2 (Rp 76,000), bukan masa 1 + masa 1.2 + masa 2\n";
