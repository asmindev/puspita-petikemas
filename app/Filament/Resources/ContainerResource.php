<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContainerResource\Pages;
use App\Filament\Resources\ContainerResource\RelationManagers;
use App\Models\Container;
use App\Models\User;
use App\Services\QueueService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class ContainerResource extends Resource
{
    protected static ?string $model = Container::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationLabel = 'Kelola Kontainer';

    protected static ?string $modelLabel = 'Kontainer';

    protected static ?string $pluralModelLabel = 'Kontainer';

    protected static ?string $navigationGroup = 'Container Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kontainer')
                    ->schema([
                        Forms\Components\TextInput::make('container_number')
                            ->label('Nomor Kontainer')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->required()
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->options(User::where('role', 'customer')->pluck('name', 'id'))
                            ->helperText('Pilih perusahaan yang memiliki barang dalam kontainer'),

                        Forms\Components\Select::make('priority')
                            ->label('Prioritas')
                            ->required()
                            ->options(Container::getPriorityOptions())
                            ->default('Normal')
                            ->reactive(),
                    ])->columns(3),

                Forms\Components\Section::make('Jadwal & Status')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_masuk')
                            ->label('Tanggal Masuk')
                            ->required()
                            ->default(now()),

                        Forms\Components\DatePicker::make('tanggal_keluar')
                            ->label('Tanggal Keluar')
                            // ->disabled()
                            ->required(),
                        // ->dehydrated(false),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'waiting' => 'Menunggu',
                                'processing' => 'Sedang Diproses',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->default('waiting'),

                        Forms\Components\TextInput::make('waktu_estimasi')
                            ->label('Estimasi Waktu (menit)')
                            ->numeric()
                            ->default(30)
                            ->suffix('menit'),
                    ])->columns(2),

                Forms\Components\Section::make('Waktu Proses')
                    ->schema([
                        Forms\Components\DateTimePicker::make('waktu_mulai_proses')
                            ->label('Waktu Mulai Proses')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\DateTimePicker::make('waktu_selesai_proses')
                            ->label('Waktu Selesai Proses')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2)
                    ->collapsible()
                    ->visible(false)
                    ->collapsed(),

                Forms\Components\Section::make('Denda & Penalti')
                    ->schema([
                        Forms\Components\Toggle::make('status_denda')
                            ->label('Ada Denda')
                            ->reactive()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('jumlah_denda')
                            ->label('Jumlah Denda')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->visible(fn(Forms\Get $get) => $get('status_denda')),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan Denda')
                            ->rows(2)
                            ->visible(fn(Forms\Get $get) => $get('status_denda')),
                    ])->columns(2)
                    ->collapsible()
                    ->visible(false)
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('container_number')
                    ->label('Nomor Container')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(30),

                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->label('Target Keluar')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->color(function ($record) {
                        if (!$record->tanggal_keluar || $record->status !== 'waiting') return 'gray';

                        $today = now()->startOfDay();
                        $scheduledExit = $record->tanggal_keluar->startOfDay();

                        if ($today > $scheduledExit) return 'danger';
                        if ($today->addDay() >= $scheduledExit) return 'warning';
                        return 'success';
                    })
                    ->weight(function ($record) {
                        if (!$record->tanggal_keluar || $record->status !== 'waiting') return 'normal';
                        return now()->startOfDay() > $record->tanggal_keluar->startOfDay() ? 'bold' : 'normal';
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($record) => match ($record->status) {
                        'waiting' => 'warning',
                        'processing' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('storage_duration')
                    ->label('Durasi (hari)')
                    ->formatStateUsing(fn($record) => $record->storage_duration . ' hari')
                    ->alignCenter()
                    ->color(fn($record) => match (true) {
                        $record->actual_storage_duration > 14 => 'danger',
                        $record->actual_storage_duration > 7 => 'warning',
                        $record->actual_storage_duration > 1 => 'info',
                        default => 'success',
                    })
                    ->weight(fn($record) => $record->actual_storage_duration > 1 ? 'semibold' : 'normal'),

                Tables\Columns\TextColumn::make('calculated_penalty')
                    ->label('Denda')
                    ->formatStateUsing(function ($record) {
                        $penalty = $record->calculated_penalty;
                        if ($penalty > 0) {
                            return 'Rp ' . number_format($penalty, 0, ',', '.');
                        }
                        return '-';
                    })
                    ->alignRight()
                    ->color(fn($record) => $record->calculated_penalty > 0 ? 'danger' : 'gray')
                    ->weight(fn($record) => $record->calculated_penalty > 0 ? 'semibold' : 'normal'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'waiting' => 'Menunggu',
                        'processing' => 'Sedang Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->multiple()
                    ->placeholder('Pilih Status'),

                SelectFilter::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Customer'),

                SelectFilter::make('priority')
                    ->label('Prioritas')
                    ->options(Container::getPriorityOptions())
                    ->multiple()
                    ->placeholder('Pilih Prioritas'),

                SelectFilter::make('status_denda')
                    ->label('Status Denda')
                    ->options([
                        1 => 'Ada Denda',
                        0 => 'Tidak Ada Denda',
                    ])
                    ->placeholder('Pilih Status Denda'),

                Tables\Filters\Filter::make('tanggal_masuk')
                    ->form([
                        Forms\Components\DatePicker::make('masuk_dari')
                            ->label('Masuk Dari'),
                        Forms\Components\DatePicker::make('masuk_sampai')
                            ->label('Masuk Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['masuk_dari'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_masuk', '>=', $date),
                            )
                            ->when(
                                $data['masuk_sampai'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_masuk', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (! $data['masuk_dari'] && ! $data['masuk_sampai']) {
                            return null;
                        }

                        return 'Tanggal masuk: ' .
                            ($data['masuk_dari'] ? 'dari ' . \Carbon\Carbon::parse($data['masuk_dari'])->format('d/m/Y') : '') .
                            ($data['masuk_dari'] && $data['masuk_sampai'] ? ' ' : '') .
                            ($data['masuk_sampai'] ? 'sampai ' . \Carbon\Carbon::parse($data['masuk_sampai'])->format('d/m/Y') : '');
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalWidth('7xl'),

                Tables\Actions\EditAction::make()
                    ->modalWidth('6xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('bulk_start_processing')
                        ->label('Mulai Proses Massal')
                        ->icon('heroicon-o-play')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $processed = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'waiting') {
                                    $record->startProcessing();
                                    $processed++;
                                }
                            }

                            Notification::make()
                                ->title('Proses massal berhasil')
                                ->body("{$processed} kontainer mulai diproses")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('bulk_complete_processing')
                        ->label('Selesai Massal')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                            $completed = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'processing') {
                                    $record->completeProcessing();
                                    $completed++;
                                }
                            }

                            Notification::make()
                                ->title('Penyelesaian massal berhasil')
                                ->body("{$completed} kontainer telah selesai diproses")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation(),

                    Tables\Actions\BulkAction::make('bulk_update_priority')
                        ->label('Ubah Prioritas Massal')
                        ->icon('heroicon-o-arrow-up')
                        ->color('info')
                        ->form([
                            Forms\Components\Select::make('priority')
                                ->label('Prioritas Baru')
                                ->options(Container::getPriorityOptions())
                                ->required(),
                        ])
                        ->action(function (array $data, \Illuminate\Database\Eloquent\Collection $records) {
                            $updated = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'waiting') {
                                    $record->update(['priority' => $data['priority']]);
                                    $updated++;
                                }
                            }

                            // Update queue positions using priority scheduler
                            $queueService = new QueueService();
                            $queueService->updatePriorityQueuePositions();

                            Notification::make()
                                ->title('Prioritas diperbarui')
                                ->body("{$updated} kontainer prioritasnya diubah ke {$data['priority']}")
                                ->info()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('tanggal_masuk', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContainers::route('/'),
            'create' => Pages\CreateContainer::route('/create'),
            'edit' => Pages\EditContainer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('customer');
    }
}
