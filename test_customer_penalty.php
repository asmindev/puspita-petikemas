<?php

require_once 'vendor/autoload.php';

use App\Models\Customer;
use App\Services\PenaltyCalculationService;

// Initialize Laravel app
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Customer Penalty Calculation\n";
echo "=====================================\n\n";

try {
    // Get customers with their containers
    $customers = Customer::withCount('containers')
        ->with(['containers' => function ($query) {
            $query->whereNotNull('exit_date');
        }])
        ->orderBy('name')
        ->take(5) // Limit to 5 for testing
        ->get();

    foreach ($customers as $customer) {
        echo "Customer: {$customer->name}\n";
        echo "Container Count: {$customer->containers_count}\n";

        $totalPenalty = 0;
        foreach ($customer->containers as $container) {
            $penaltyInfo = PenaltyCalculationService::calculateDeliveryPenalty($container);
            $totalPenalty += $penaltyInfo['total_amount'];

            if ($penaltyInfo['total_amount'] > 0) {
                echo "  - Container {$container->container_number}: Rp " . number_format($penaltyInfo['total_amount'], 0, ',', '.') . "\n";
            }
        }

        echo "Total Penalty: Rp " . number_format($totalPenalty, 0, ',', '.') . "\n";
        echo "---\n\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
