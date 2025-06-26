<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Container;

class ContainersRelationManager extends RelationManager
{
    protected static string $relationship = 'containers';

    protected static ?string $title = 'Container';

    protected static ?string $modelLabel = 'Container';

    protected static ?string $pluralModelLabel = 'Container';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('container_number')
                    ->label('Nomor Container')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('priority')
                    ->label('Prioritas')
                    ->required()
                    ->options(Container::getPriorityOptions())
                    ->default('Normal'),

                Forms\Components\DatePicker::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->required()
                    ->default(now()),

                Forms\Components\DatePicker::make('tanggal_keluar')
                    ->label('Tanggal Keluar')
                    ->required(),

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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('container_number')
            ->columns([
                Tables\Columns\TextColumn::make('container_number')
                    ->label('Nomor Container')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

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
                    }),

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
                    ->color(fn($record) => $record->calculated_penalty > 0 ? 'danger' : 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'waiting' => 'Menunggu',
                        'processing' => 'Sedang Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal_masuk', 'desc');
    }
}
