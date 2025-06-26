<?php

namespace App\Services;

use App\Models\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class AnalyticsService
{
    /**
     * Get comprehensive queue analytics for a given period
     */
    public function getQueueAnalytics(Carbon $startDate, Carbon $endDate): array
    {
        $containers = Container::whereBetween('waktu_kedatangan', [$startDate, $endDate])
            ->whereNotNull('waktu_selesai_proses')
            ->get();

        return [
            'summary' => $this->calculateSummaryMetrics($containers),
            'hourly_distribution' => $this->getHourlyDistribution($containers),
            'priority_analysis' => $this->getPriorityAnalysis($containers),
            'customer_analysis' => $this->getCustomerAnalysis($containers),
            'processing_trends' => $this->getProcessingTrends($containers),
            'efficiency_metrics' => $this->getEfficiencyMetrics($containers),
            'bottleneck_analysis' => $this->getBottleneckAnalysis($containers)
        ];
    }

    /**
     * Calculate summary metrics
     */
    private function calculateSummaryMetrics(Collection $containers): array
    {
        if ($containers->isEmpty()) {
            return [
                'total_containers' => 0,
                'avg_processing_time' => 0,
                'avg_waiting_time' => 0,
                'throughput_per_hour' => 0,
                'efficiency_rate' => 0
            ];
        }

        $processingTimes = $containers->map(function ($container) {
            return $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
        });

        $waitingTimes = $containers->map(function ($container) {
            return $container->waktu_mulai_proses->diffInMinutes($container->waktu_kedatangan);
        });

        $totalHours = $containers->first()->waktu_kedatangan
            ->diffInHours($containers->last()->waktu_selesai_proses);

        return [
            'total_containers' => $containers->count(),
            'avg_processing_time' => round($processingTimes->avg(), 2),
            'avg_waiting_time' => round($waitingTimes->avg(), 2),
            'min_processing_time' => $processingTimes->min(),
            'max_processing_time' => $processingTimes->max(),
            'throughput_per_hour' => $totalHours > 0 ? round($containers->count() / $totalHours, 2) : 0,
            'efficiency_rate' => $this->calculateEfficiencyRate($containers)
        ];
    }

    /**
     * Get hourly distribution of container arrivals and completions
     */
    private function getHourlyDistribution(Collection $containers): array
    {
        $hourlyData = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $arrivals = $containers->filter(function ($container) use ($hour) {
                return $container->waktu_kedatangan->format('H') == $hour;
            })->count();

            $completions = $containers->filter(function ($container) use ($hour) {
                return $container->waktu_selesai_proses->format('H') == $hour;
            })->count();

            $hourlyData[] = [
                'hour' => sprintf('%02d:00', $hour),
                'arrivals' => $arrivals,
                'completions' => $completions
            ];
        }

        return $hourlyData;
    }

    /**
     * Analyze performance by priority level
     */
    private function getPriorityAnalysis(Collection $containers): array
    {
        $priorities = ['High', 'Medium', 'Low'];
        $analysis = [];

        foreach ($priorities as $priority) {
            $priorityContainers = $containers->where('priority', $priority);

            if ($priorityContainers->isEmpty()) {
                $analysis[$priority] = [
                    'count' => 0,
                    'avg_processing_time' => 0,
                    'avg_waiting_time' => 0,
                    'percentage' => 0
                ];
                continue;
            }

            $processingTimes = $priorityContainers->map(function ($container) {
                return $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
            });

            $waitingTimes = $priorityContainers->map(function ($container) {
                return $container->waktu_mulai_proses->diffInMinutes($container->waktu_kedatangan);
            });

            $analysis[$priority] = [
                'count' => $priorityContainers->count(),
                'avg_processing_time' => round($processingTimes->avg(), 2),
                'avg_waiting_time' => round($waitingTimes->avg(), 2),
                'percentage' => round(($priorityContainers->count() / $containers->count()) * 100, 1)
            ];
        }

        return $analysis;
    }

    /**
     * Analyze performance by customer
     */
    private function getCustomerAnalysis(Collection $containers): array
    {
        return $containers->groupBy('customer')
            ->map(function ($customerContainers, $customer) use ($containers) {
                $processingTimes = $customerContainers->map(function ($container) {
                    return $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
                });

                return [
                    'customer' => $customer,
                    'count' => $customerContainers->count(),
                    'avg_processing_time' => round($processingTimes->avg(), 2),
                    'percentage' => round(($customerContainers->count() / $containers->count()) * 100, 1),
                    'priority_distribution' => $customerContainers->groupBy('priority')
                        ->map->count()
                        ->toArray()
                ];
            })
            ->sortByDesc('count')
            ->values()
            ->toArray();
    }

    /**
     * Get processing trends over time
     */
    private function getProcessingTrends(Collection $containers): array
    {
        return $containers->groupBy(function ($container) {
            return $container->waktu_kedatangan->format('Y-m-d');
        })
            ->map(function ($dailyContainers, $date) {
                $processingTimes = $dailyContainers->map(function ($container) {
                    return $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
                });

                $waitingTimes = $dailyContainers->map(function ($container) {
                    return $container->waktu_mulai_proses->diffInMinutes($container->waktu_kedatangan);
                });

                return [
                    'date' => $date,
                    'count' => $dailyContainers->count(),
                    'avg_processing_time' => round($processingTimes->avg(), 2),
                    'avg_waiting_time' => round($waitingTimes->avg(), 2)
                ];
            })
            ->sortBy('date')
            ->values()
            ->toArray();
    }

    /**
     * Calculate detailed efficiency metrics
     */
    private function getEfficiencyMetrics(Collection $containers): array
    {
        if ($containers->isEmpty()) {
            return [];
        }

        $totalProcessingTime = $containers->sum(function ($container) {
            return $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
        });

        $totalWaitingTime = $containers->sum(function ($container) {
            return $container->waktu_mulai_proses->diffInMinutes($container->waktu_kedatangan);
        });

        $totalSystemTime = $totalProcessingTime + $totalWaitingTime;
        $utilization = $totalSystemTime > 0 ? ($totalProcessingTime / $totalSystemTime) * 100 : 0;

        return [
            'total_processing_time' => $totalProcessingTime,
            'total_waiting_time' => $totalWaitingTime,
            'utilization_rate' => round($utilization, 2),
            'avg_service_rate' => round($containers->count() / ($totalProcessingTime / 60), 2), // containers per hour
            'throughput_efficiency' => $this->calculateThroughputEfficiency($containers)
        ];
    }

    /**
     * Identify bottlenecks in the system
     */
    private function getBottleneckAnalysis(Collection $containers): array
    {
        $analysis = [];

        // Peak hour analysis
        $hourlyLoad = $containers->groupBy(function ($container) {
            return $container->waktu_kedatangan->format('H');
        })->map->count()->sortDesc();

        $peakHour = $hourlyLoad->keys()->first();
        $analysis['peak_hour'] = [
            'hour' => sprintf('%02d:00', $peakHour),
            'container_count' => $hourlyLoad->first()
        ];

        // Long processing times
        $longProcessingContainers = $containers->filter(function ($container) {
            $processingTime = $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
            return $processingTime > 30; // Consider >30 minutes as long
        });

        $analysis['long_processing'] = [
            'count' => $longProcessingContainers->count(),
            'percentage' => round(($longProcessingContainers->count() / $containers->count()) * 100, 1),
            'avg_time' => $longProcessingContainers->isEmpty() ? 0 :
                round($longProcessingContainers->avg(function ($container) {
                    return $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
                }), 2)
        ];

        // Priority queue effectiveness
        $highPriorityContainers = $containers->where('priority', 'High');
        $avgHighPriorityWait = $highPriorityContainers->isEmpty() ? 0 :
            round($highPriorityContainers->avg(function ($container) {
                return $container->waktu_mulai_proses->diffInMinutes($container->waktu_kedatangan);
            }), 2);

        $analysis['priority_effectiveness'] = [
            'high_priority_avg_wait' => $avgHighPriorityWait,
            'is_effective' => $avgHighPriorityWait < 15 // Consider <15 minutes as effective
        ];

        return $analysis;
    }

    /**
     * Calculate efficiency rate
     */
    private function calculateEfficiencyRate(Collection $containers): float
    {
        if ($containers->isEmpty()) {
            return 0;
        }

        $idealProcessingTime = 20; // minutes per container (baseline)
        $actualAvgProcessingTime = $containers->avg(function ($container) {
            return $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
        });

        $efficiency = ($idealProcessingTime / $actualAvgProcessingTime) * 100;
        return round(min($efficiency, 100), 2); // Cap at 100%
    }

    /**
     * Calculate throughput efficiency
     */
    private function calculateThroughputEfficiency(Collection $containers): float
    {
        if ($containers->isEmpty()) {
            return 0;
        }

        $timeSpan = $containers->first()->waktu_kedatangan
            ->diffInHours($containers->last()->waktu_selesai_proses);

        if ($timeSpan <= 0) {
            return 0;
        }

        $actualThroughput = $containers->count() / $timeSpan;
        $expectedThroughput = 3; // Expected 3 containers per hour

        return round(min(($actualThroughput / $expectedThroughput) * 100, 100), 2);
    }

    /**
     * Generate optimization recommendations
     */
    public function generateOptimizationRecommendations(array $analytics): array
    {
        $recommendations = [];

        // Check efficiency
        if ($analytics['summary']['efficiency_rate'] < 70) {
            $recommendations[] = "Efisiensi sistem rendah ({$analytics['summary']['efficiency_rate']}%). Pertimbangkan untuk menambah kapasitas atau mengoptimalkan proses.";
        }

        // Check waiting times
        if ($analytics['summary']['avg_waiting_time'] > 30) {
            $recommendations[] = "Waktu tunggu rata-rata tinggi ({$analytics['summary']['avg_waiting_time']} menit). Pertimbangkan implementasi sistem prioritas yang lebih agresif.";
        }

        // Check bottlenecks
        if (
            isset($analytics['bottleneck_analysis']['long_processing']['percentage']) &&
            $analytics['bottleneck_analysis']['long_processing']['percentage'] > 20
        ) {
            $recommendations[] = "Terdapat {$analytics['bottleneck_analysis']['long_processing']['percentage']}% container dengan waktu proses lama. Identifikasi penyebab keterlambatan.";
        }

        // Check peak hour management
        if (
            isset($analytics['bottleneck_analysis']['peak_hour']['container_count']) &&
            $analytics['bottleneck_analysis']['peak_hour']['container_count'] > 10
        ) {
            $peakHour = $analytics['bottleneck_analysis']['peak_hour']['hour'];
            $recommendations[] = "Jam sibuk di {$peakHour} memerlukan perhatian khusus. Pertimbangkan penambahan tenaga kerja pada jam tersebut.";
        }

        // Check priority system effectiveness
        if (
            isset($analytics['bottleneck_analysis']['priority_effectiveness']['is_effective']) &&
            !$analytics['bottleneck_analysis']['priority_effectiveness']['is_effective']
        ) {
            $recommendations[] = "Sistem prioritas kurang efektif. Container prioritas tinggi masih menunggu terlalu lama.";
        }

        return $recommendations;
    }

    /**
     * Get real-time queue status
     */
    public function getRealTimeQueueStatus(): array
    {
        $waitingContainers = Container::where('status', 'Waiting')
            ->orderBy('priority', 'desc')
            ->orderBy('waktu_kedatangan', 'asc')
            ->get();

        $processingContainers = Container::where('status', 'Processing')->get();

        $currentWaitTimes = $waitingContainers->map(function ($container) {
            return [
                'container_number' => $container->container_number,
                'wait_time' => $container->waktu_kedatangan->diffInMinutes(now()),
                'priority' => $container->priority,
                'customer' => $container->customer
            ];
        });

        return [
            'queue_length' => $waitingContainers->count(),
            'processing_count' => $processingContainers->count(),
            'avg_wait_time' => $currentWaitTimes->avg('wait_time') ?? 0,
            'longest_wait' => $currentWaitTimes->max('wait_time') ?? 0,
            'priority_distribution' => $waitingContainers->groupBy('priority')->map->count(),
            'waiting_containers' => $currentWaitTimes->toArray()
        ];
    }
}
