<?php

namespace App\Services;

use App\Models\Container;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class NotificationService
{
    /**
     * Send notification when a container enters the queue
     */
    public function notifyContainerQueued(Container $container): void
    {
        try {
            $message = "Container {$container->container_number} telah masuk antrian dengan prioritas {$container->priority}";

            // Log the event
            Log::info('Container queued', [
                'container_id' => $container->id,
                'container_number' => $container->container_number,
                'priority' => $container->priority,
                'customer' => $container->customer
            ]);

            // Send notification to operators
            $this->sendToOperators(
                'Container Masuk Antrian',
                $message,
                'info'
            );
        } catch (\Exception $e) {
            Log::error('Failed to send queue notification', [
                'container_id' => $container->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send notification when container processing starts
     */
    public function notifyProcessingStarted(Container $container): void
    {
        try {
            $message = "Pemrosesan container {$container->container_number} dimulai";

            Log::info('Container processing started', [
                'container_id' => $container->id,
                'container_number' => $container->container_number,
                'started_at' => $container->waktu_mulai_proses
            ]);

            $this->sendToOperators(
                'Pemrosesan Dimulai',
                $message,
                'success'
            );
        } catch (\Exception $e) {
            Log::error('Failed to send processing notification', [
                'container_id' => $container->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send notification when container processing completes
     */
    public function notifyProcessingCompleted(Container $container): void
    {
        try {
            $processingTime = $container->waktu_selesai_proses->diffInMinutes($container->waktu_mulai_proses);
            $message = "Container {$container->container_number} selesai diproses dalam {$processingTime} menit";

            Log::info('Container processing completed', [
                'container_id' => $container->id,
                'container_number' => $container->container_number,
                'processing_time' => $processingTime,
                'completed_at' => $container->waktu_selesai_proses
            ]);

            $this->sendToOperators(
                'Pemrosesan Selesai',
                $message,
                'success'
            );
        } catch (\Exception $e) {
            Log::error('Failed to send completion notification', [
                'container_id' => $container->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send notification for queue optimization suggestions
     */
    public function notifyQueueOptimization(array $suggestions): void
    {
        try {
            if (empty($suggestions)) {
                return;
            }

            $message = "Saran optimasi antrian tersedia:\n" . implode("\n", $suggestions);

            Log::info('Queue optimization suggestions', [
                'suggestions' => $suggestions
            ]);

            $this->sendToOperators(
                'Optimasi Antrian',
                $message,
                'warning'
            );
        } catch (\Exception $e) {
            Log::error('Failed to send optimization notification', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send notification for queue alerts (long waiting times, etc.)
     */
    public function notifyQueueAlert(string $alertType, array $data): void
    {
        try {
            $messages = [
                'long_wait' => "Container {$data['container_number']} telah menunggu {$data['wait_time']} menit",
                'queue_overflow' => "Antrian mencapai {$data['queue_length']} container - perlu perhatian",
                'low_efficiency' => "Efisiensi sistem turun menjadi {$data['efficiency']}%",
                'processing_delay' => "Container {$data['container_number']} mengalami keterlambatan pemrosesan"
            ];

            $message = $messages[$alertType] ?? 'Alert tidak dikenal';

            Log::warning('Queue alert triggered', [
                'alert_type' => $alertType,
                'data' => $data
            ]);

            $this->sendToOperators(
                'Peringatan Antrian',
                $message,
                'danger'
            );
        } catch (\Exception $e) {
            Log::error('Failed to send queue alert', [
                'alert_type' => $alertType,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send daily queue summary
     */
    public function sendDailySummary(array $summary): void
    {
        try {
            $message = "Ringkasan harian:\n" .
                "- Container diproses: {$summary['total_processed']}\n" .
                "- Waktu rata-rata: {$summary['avg_processing_time']} menit\n" .
                "- Efisiensi: {$summary['efficiency']}%\n" .
                "- Queue tertinggi: {$summary['peak_queue_length']} container";

            Log::info('Daily summary sent', $summary);

            $this->sendToOperators(
                'Ringkasan Harian',
                $message,
                'info'
            );
        } catch (\Exception $e) {
            Log::error('Failed to send daily summary', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send notification to all operators
     */
    private function sendToOperators(string $title, string $message, string $type = 'info'): void
    {
        // Get all users with operator role
        $operators = User::where('role', 'operator')->get();

        foreach ($operators as $operator) {
            Notification::make()
                ->title($title)
                ->body($message)
                ->icon($this->getIconForType($type))
                ->color($type)
                ->persistent()
                ->sendToDatabase($operator);
        }
    }

    /**
     * Get icon based on notification type
     */
    private function getIconForType(string $type): string
    {
        return match ($type) {
            'success' => 'heroicon-o-check-circle',
            'warning' => 'heroicon-o-exclamation-triangle',
            'danger' => 'heroicon-o-x-circle',
            'info' => 'heroicon-o-information-circle',
            default => 'heroicon-o-bell'
        };
    }

    /**
     * Check queue health and send alerts if needed
     */
    public function checkQueueHealth(): void
    {
        try {
            $queueService = app(QueueService::class);

            // Check for long waiting times
            $longWaitingContainers = Container::where('status', 'Waiting')
                ->where('waktu_kedatangan', '<=', now()->subMinutes(60))
                ->get();

            foreach ($longWaitingContainers as $container) {
                $waitTime = round($container->waktu_kedatangan->diffInMinutes(now()));
                $this->notifyQueueAlert('long_wait', [
                    'container_number' => $container->container_number,
                    'wait_time' => $waitTime
                ]);
            }

            // Check queue length
            $queueLength = Container::where('status', 'Waiting')->count();
            if ($queueLength > 20) {
                $this->notifyQueueAlert('queue_overflow', [
                    'queue_length' => $queueLength
                ]);
            }

            // Check efficiency
            $metrics = $queueService->calculatePerformanceMetrics();
            if ($metrics['efficiency_rate'] < 70) {
                $this->notifyQueueAlert('low_efficiency', [
                    'efficiency' => $metrics['efficiency_rate']
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to check queue health', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
