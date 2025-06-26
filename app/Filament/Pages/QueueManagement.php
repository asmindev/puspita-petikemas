<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Services\QueueService;
use App\Models\Container;
use Filament\Actions;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;

class QueueManagement extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static string $view = 'filament.pages.queue-management';
    protected static ?string $title = 'Manajemen Antrian';
    protected static ?string $navigationLabel = 'Manajemen Antrian';
    protected static ?int $navigationSort = 2;

    public ?Container $nextContainer = null;
    public Collection $queueList;
    public Collection $processingContainers;
    public array $statistics = [];

    public function mount(): void
    {
        $this->queueList = collect();
        $this->processingContainers = collect();
        $this->loadData();
    }

    /**
     * Get QueueService instance
     */
    protected function getQueueService(): QueueService
    {
        return app(QueueService::class);
    }

    /**
     * Load semua data antrian
     */
    public function loadData(): void
    {
        $queueService = $this->getQueueService();

        $this->nextContainer = $queueService->getNextContainer();
        $this->queueList = $queueService->getQueue();
        $this->processingContainers = $queueService->getProcessingContainers();
        $this->statistics = $queueService->getStatistics();
    }

    /**
     * Proses kontainer berikutnya
     */
    public function processNext(): void
    {
        $queueService = $this->getQueueService();
        $processed = $queueService->processNext();

        if ($processed) {
            Notification::make()
                ->title('Kontainer Diproses')
                ->body("Kontainer {$processed->container_number} ({$processed->customer->name}) mulai diproses menggunakan algoritma FCFS + Priority Scheduler")
                ->success()
                ->duration(5000)
                ->send();
        } else {
            Notification::make()
                ->title('Tidak ada kontainer dalam antrian')
                ->body('Semua kontainer sudah diproses atau tidak ada yang menunggu')
                ->warning()
                ->send();
        }

        $this->loadData();
    }

    /**
     * Selesaikan pemrosesan kontainer
     */
    public function completeProcessing(int $containerId): void
    {
        $container = Container::find($containerId);

        if (!$container || !($container instanceof Container)) {
            Notification::make()
                ->title('Kontainer tidak ditemukan')
                ->danger()
                ->send();
            return;
        }

        $queueService = $this->getQueueService();
        $completed = $queueService->completeProcessing($container);

        if ($completed) {
            Notification::make()
                ->title('Proses selesai')
                ->body("Kontainer {$container->container_number} telah selesai diproses")
                ->success()
                ->duration(5000)
                ->send();
        } else {
            Notification::make()
                ->title('Tidak dapat menyelesaikan')
                ->body('Kontainer tidak sedang diproses')
                ->warning()
                ->send();
        }

        $this->loadData();
    }

    /**
     * Refresh data manual
     */
    public function refreshData(): void
    {
        $this->loadData();

        Notification::make()
            ->title('Data diperbarui')
            ->success()
            ->send();
    }

    /**
     * Actions header
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Segarkan Data')
                ->icon('heroicon-o-arrow-path')
                ->action('refreshData'),

            Actions\Action::make('processNext')
                ->label('Proses Berikutnya')
                ->icon('heroicon-o-play')
                ->color('success')
                ->action('processNext')
                ->disabled(fn() => !$this->nextContainer)
        ];
    }

    /**
     * Get priority badge color
     */
    public function getPriorityColor(string $priority): string
    {
        return match ($priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'normal' => 'success',
            default => 'gray'
        };
    }

    /**
     * Format duration in human readable format
     */
    public function formatDuration(int $minutes): string
    {
        if ($minutes < 60) {
            return "{$minutes} menit";
        }

        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;

        if ($remainingMinutes > 0) {
            return "{$hours} jam {$remainingMinutes} menit";
        }

        return "{$hours} jam";
    }
}
