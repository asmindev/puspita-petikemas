<?php

/*
 * Container Queue Service Demonstration
 *
 * This script demonstrates the FCFS + Priority Scheduler algorithm
 * Run this with: php artisan tinker < demo_queue_service.php
 */

echo "=== Container Queue Service Demonstration ===\n\n";

// Create queue service instance
$queueService = new \App\Services\ContainerQueueService();

echo "1. Current Queue Statistics:\n";
$stats = $queueService->getQueueStatistics();
echo "   - Total Pending: {$stats['total_pending']}\n";
echo "   - High Priority: {$stats['high_priority_pending']}\n";
echo "   - Normal Priority: {$stats['normal_priority_pending']}\n";
echo "   - Average Wait Time: " . number_format($stats['average_wait_time_minutes'], 1) . " minutes\n\n";

echo "2. Next Container to Process:\n";
$nextContainer = $queueService->getNextContainer();
if ($nextContainer) {
    echo "   - Container: {$nextContainer->container_number}\n";
    echo "   - Customer: {$nextContainer->customer->name}\n";
    echo "   - Priority: {$nextContainer->priority}\n";
    echo "   - Entry Date: {$nextContainer->entry_date->format('Y-m-d H:i:s')}\n";
    echo "   - Queue Position: " . $queueService->getQueuePosition($nextContainer) . "\n\n";
} else {
    echo "   - No containers in queue\n\n";
}

echo "3. Queue Order (First 10 containers):\n";
$queuedContainers = $queueService->getQueuedContainers(['status' => 'pending'], 10);
foreach ($queuedContainers as $index => $container) {
    $position = $index + 1;
    echo "   {$position}. {$container->container_number} ({$container->priority}) - {$container->customer->name}\n";
    echo "      Entry: {$container->entry_date->format('Y-m-d H:i:s')} - Wait: {$container->entry_date->diffForHumans()}\n";
}

if ($queuedContainers->isEmpty()) {
    echo "   - No containers in queue\n";
}

echo "\n4. Processing Simulation (Next 5 containers):\n";
$simulation = $queueService->simulateQueueProcessing(5);
echo "   - Total Containers: {$simulation['total_containers']}\n";
echo "   - Estimated Total Time: {$simulation['total_estimated_time']} minutes\n";
echo "   - High Priority Count: {$simulation['high_priority_count']}\n\n";

if (!empty($simulation['containers'])) {
    echo "   Processing Timeline:\n";
    foreach ($simulation['containers'] as $item) {
        $container = $item['container'];
        echo "   {$item['position']}. {$container['container_number']} ({$container['priority']})\n";
        echo "      Start: {$item['estimated_start_time']}\n";
        echo "      Complete: {$item['estimated_completion_time']}\n";
        echo "      Wait: {$item['estimated_wait_time']} minutes\n\n";
    }
}

echo "5. Detailed Queue Information:\n";
$detailedQueue = $queueService->getDetailedQueueInfo();
if (!empty($detailedQueue)) {
    echo "   Position | Container | Priority | Est. Start | Est. Complete | Wait Time\n";
    echo "   ---------|-----------|----------|------------|---------------|----------\n";
    foreach (array_slice($detailedQueue, 0, 5) as $item) {
        $container = $item['container'];
        printf(
            "   %-8d | %-9s | %-8s | %-10s | %-13s | %d min\n",
            $item['position'],
            $container->container_number,
            $container->priority,
            $item['estimated_start_time']->format('H:i'),
            $item['estimated_completion_time']->format('H:i'),
            $item['estimated_wait_time']
        );
    }
} else {
    echo "   - No containers in detailed queue\n";
}

echo "\n=== Demonstration Complete ===\n";
echo "The queue follows FCFS + Priority algorithm:\n";
echo "1. High priority containers are processed first\n";
echo "2. Within same priority, earliest entry date is processed first\n";
echo "3. Queue positions and wait times are calculated dynamically\n";
echo "4. Processing simulation helps with resource planning\n";
