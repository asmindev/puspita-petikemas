<?php

namespace App\Services;

use App\Models\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

/**
 * Container Queue Service
 *
 * Implements FIRST COME FIRST SERVE (FCFS) algorithm with Priority Scheduler
 * - High Priority containers are processed first
 * - Within same priority level, containers are ordered by entry_date (earliest first)
 */
class ContainerQueueService
{
    /**
     * Priority levels in order of importance
     */
    const PRIORITY_ORDER = [
        'High' => 1,
        'Normal' => 2
    ];

    /**
     * Get containers ordered by Priority + FCFS algorithm
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getQueuedContainers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Container::with('customer');

        // Apply filters if provided
        $this->applyFilters($query, $filters);

        // Get all containers first
        $containers = $query->get();

        // Apply Priority + FCFS sorting
        $sortedContainers = $this->sortByPriorityAndFCFS($containers);

        // Convert to paginated result
        return $this->paginateCollection($sortedContainers, $perPage);
    }

    /**
     * Get queue for pending containers only
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPendingQueue(int $perPage = 15): LengthAwarePaginator
    {
        return $this->getQueuedContainers(['status' => 'pending'], $perPage);
    }

    /**
     * Get next container to process based on Priority + FCFS
     *
     * @return Container|null
     */
    public function getNextContainer(): ?Container
    {
        $pendingContainers = Container::with('customer')
            ->where('status', 'pending')
            ->get();

        if ($pendingContainers->isEmpty()) {
            return null;
        }

        $sortedContainers = $this->sortByPriorityAndFCFS($pendingContainers);

        return $sortedContainers->first();
    }

    /**
     * Get queue position for a specific container
     *
     * @param Container $container
     * @return int
     */
    public function getQueuePosition(Container $container): int
    {
        if ($container->status !== 'pending') {
            return 0; // Not in queue
        }

        $pendingContainers = Container::with('customer')
            ->where('status', 'pending')
            ->get();

        $sortedContainers = $this->sortByPriorityAndFCFS($pendingContainers);

        $position = $sortedContainers->search(function ($item) use ($container) {
            return $item->id === $container->id;
        });

        return $position !== false ? $position + 1 : 0;
    }

    /**
     * Get queue statistics
     *
     * @return array
     */
    public function getQueueStatistics(): array
    {
        $totalPending = Container::where('status', 'pending')->count();
        $highPriorityPending = Container::where('status', 'pending')
            ->where('priority', 'High')
            ->count();
        $normalPriorityPending = Container::where('status', 'pending')
            ->where('priority', 'Normal')
            ->count();

        $avgWaitTime = $this->calculateAverageWaitTime();
        $estimatedProcessTime = $this->calculateEstimatedProcessTime();

        return [
            'total_pending' => $totalPending,
            'high_priority_pending' => $highPriorityPending,
            'normal_priority_pending' => $normalPriorityPending,
            'average_wait_time_minutes' => $avgWaitTime,
            'estimated_total_process_time_minutes' => $estimatedProcessTime,
        ];
    }

    /**
     * Sort containers by Priority first, then by FCFS (entry_date)
     *
     * @param Collection $containers
     * @return Collection
     */
    protected function sortByPriorityAndFCFS(Collection $containers): Collection
    {
        return $containers->sort(function ($a, $b) {
            // pertama, bandingkan berdasarkan prioritas (Prioritas Tinggi terlebih dahulu)
            // jika prioritas tidak ditemukan, gunakan nilai default 999,  menggunnakan 999 karena angka 999 adalah nilai yang sangat besar,
            // sehingga semua prioritas yang tidak terdefinisi akan dianggap sebagai prioritas terendah
            $priorityA = self::PRIORITY_ORDER[$a->priority] ?? 999;
            $priorityB = self::PRIORITY_ORDER[$b->priority] ?? 999;

            // jika prioritas tidak sama, kembalikan perbandingan prioritas
            if ($priorityA !== $priorityB) {
                return $priorityA <=> $priorityB;
            }
            // Jika prioritas sama (termasuk `999`), bandingkan berdasarkan entry_date (FCFS)
            $entryDateA = $a->entry_date ? $a->entry_date->timestamp : 0;
            $entryDateB = $b->entry_date ? $b->entry_date->timestamp : 0;

            return $entryDateA <=> $entryDateB;
        })->values();
    }

    /**
     * Apply filters to the query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return void
     */
    protected function applyFilters($query, array $filters): void
    {
        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('container_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('priority', 'like', "%{$search}%");
            });
        }

        // Status filter
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        // Priority filter
        if (!empty($filters['priority']) && $filters['priority'] !== 'all') {
            $query->where('priority', $filters['priority']);
        }

        // Date range filter
        if (!empty($filters['entry_date_from'])) {
            $query->where('entry_date', '>=', $filters['entry_date_from']);
        }

        if (!empty($filters['entry_date_to'])) {
            $query->where('entry_date', '<=', $filters['entry_date_to']);
        }
    }

    /**
     * Convert collection to paginated result
     *
     * @param Collection $collection
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    protected function paginateCollection(Collection $collection, int $perPage): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage);

        return new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => Request::url(),
                'pageName' => 'page',
            ]
        );
    }

    /**
     * Calculate average wait time for pending containers
     *
     * @return float
     */
    protected function calculateAverageWaitTime(): float
    {
        $pendingContainers = Container::where('status', 'pending')
            ->whereNotNull('entry_date')
            ->get();

        if ($pendingContainers->isEmpty()) {
            return 0;
        }

        $totalWaitTime = 0;
        $now = now();

        foreach ($pendingContainers as $container) {
            $waitTime = $now->diffInMinutes($container->entry_date);
            $totalWaitTime += $waitTime;
        }

        return round($totalWaitTime / $pendingContainers->count(), 2);
    }

    /**
     * Calculate estimated total process time for all pending containers
     *
     * @return int
     */
    protected function calculateEstimatedProcessTime(): int
    {
        $pendingContainers = Container::where('status', 'pending')
            ->get();

        $totalEstimatedTime = 0;
        $defaultProcessTime = 30; // Default 30 minutes per container

        foreach ($pendingContainers as $container) {
            $estimatedTime = $container->estimated_time ?? $defaultProcessTime;
            $totalEstimatedTime += $estimatedTime;
        }

        return $totalEstimatedTime;
    }

    /**
     * Get detailed queue information with positions
     *
     * @return array
     */
    public function getDetailedQueueInfo(): array
    {
        $pendingContainers = Container::with('customer')
            ->where('status', 'pending')
            ->get();

        $sortedContainers = $this->sortByPriorityAndFCFS($pendingContainers);

        $queueInfo = [];
        $cumulativeTime = 0;
        $defaultProcessTime = 30;

        foreach ($sortedContainers as $index => $container) {
            $estimatedTime = $container->estimated_time ?? $defaultProcessTime;

            $queueInfo[] = [
                'position' => $index + 1,
                'container' => $container,
                'estimated_start_time' => now()->addMinutes($cumulativeTime),
                'estimated_completion_time' => now()->addMinutes($cumulativeTime + $estimatedTime),
                'estimated_wait_time' => $cumulativeTime,
                'estimated_process_time' => $estimatedTime,
            ];

            $cumulativeTime += $estimatedTime;
        }

        return $queueInfo;
    }

    /**
     * Simulate queue processing time
     *
     * @param int $maxContainers Limit simulation to this many containers
     * @return array
     */
    public function simulateQueueProcessing(int $maxContainers = 10): array
    {
        $queueInfo = $this->getDetailedQueueInfo();

        if ($maxContainers > 0) {
            $queueInfo = array_slice($queueInfo, 0, $maxContainers);
        }

        $simulation = [
            'total_containers' => count($queueInfo),
            'total_estimated_time' => 0,
            'high_priority_count' => 0,
            'normal_priority_count' => 0,
            'containers' => $queueInfo,
        ];

        foreach ($queueInfo as $item) {
            $simulation['total_estimated_time'] += $item['estimated_process_time'];

            if ($item['container']->priority === 'High') {
                $simulation['high_priority_count']++;
            } else {
                $simulation['normal_priority_count']++;
            }
        }

        return $simulation;
    }

    /**
     * Get estimated wait time for a specific container
     *
     * @param Container $container
     * @return int Wait time in minutes
     */
    public function getEstimatedWaitTime(Container $container): int
    {
        if ($container->status !== 'pending') {
            return 0; // Not in queue
        }

        $pendingContainers = Container::with('customer')
            ->where('status', 'pending')
            ->get();

        $sortedContainers = $this->sortByPriorityAndFCFS($pendingContainers);

        $waitTime = 0;
        $defaultProcessTime = 30;

        foreach ($sortedContainers as $queuedContainer) {
            if ($queuedContainer->id === $container->id) {
                break;
            }
            $estimatedTime = $queuedContainer->estimated_time ?? $defaultProcessTime;
            $waitTime += $estimatedTime;
        }

        return $waitTime;
    }
}
