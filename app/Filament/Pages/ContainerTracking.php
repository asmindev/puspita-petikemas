<?php

namespace App\Filament\Pages;

use App\Models\Container;
use App\Services\QueueService;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ContainerTracking extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'Tracking Kontainer';

    protected static ?string $title = 'Tracking Kontainer';

    protected static string $view = 'filament.pages.container-tracking';

    public ?string $containerNumber = '';

    public ?Container $trackedContainer = null;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'containerNumber' => ''
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('containerNumber')
                    ->label('Nomor Kontainer / Nomor Antrian')
                    ->placeholder('Masukkan nomor kontainer atau nomor antrian (contoh: CSLU3000001 atau EXP-20250525-0001)')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn() => $this->searchContainer()),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('search')
                ->label('Cari Kontainer')
                ->icon('heroicon-o-magnifying-glass')
                ->action('searchContainer'),
        ];
    }

    public function searchContainer(): void
    {
        $searchValue = $this->data['containerNumber'] ?? '';

        if (empty($searchValue)) {
            $this->trackedContainer = null;
            return;
        }

        // Cari berdasarkan nomor kontainer atau nama customer melalui relasi
        $this->trackedContainer = Container::where('container_number', $searchValue)
            ->orWhereHas('customer', function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            })
            ->with('customer')
            ->first();

        if (!$this->trackedContainer) {
            Notification::make()
                ->title('Kontainer tidak ditemukan')
                ->body("Kontainer dengan nomor {$searchValue} tidak ditemukan dalam sistem.")
                ->warning()
                ->send();
        } else {
            Notification::make()
                ->title('Kontainer ditemukan!')
                ->body("Kontainer {$this->trackedContainer->container_number} berhasil ditemukan.")
                ->success()
                ->send();
        }
    }

    public function getViewData(): array
    {
        $queueService = new QueueService();
        $estimatedCompletion = null;
        $queueInfo = null;

        if ($this->trackedContainer && $this->trackedContainer->status === 'waiting') {
            // Get the current queue using the existing method
            $currentQueue = $queueService->getQueue();

            // Find the position of this container in the queue
            $position = $currentQueue->search(function ($item) {
                return $item->id === $this->trackedContainer->id;
            });

            $queueInfo = [
                'fcfs_position' => $position !== false ? $position + 1 : null,
                'priority_position' => $position !== false ? $position + 1 : null,
                'fcfs_total' => $currentQueue->count(),
                'priority_total' => $currentQueue->count(),
            ];

            // Simple estimated completion based on position and average processing time
            if ($position !== false) {
                $statistics = $queueService->getStatistics();
                $avgProcessingTime = $statistics['avg_processing_time'] ?? 30; // Default 30 minutes
                $estimatedMinutes = ($position + 1) * $avgProcessingTime;

                $estimatedCompletion = [
                    'fcfs' => now()->addMinutes($estimatedMinutes),
                    'priority' => now()->addMinutes($estimatedMinutes),
                ];
            }
        }

        return [
            'container' => $this->trackedContainer,
            'estimatedCompletion' => $estimatedCompletion,
            'queueInfo' => $queueInfo,
        ];
    }
}
