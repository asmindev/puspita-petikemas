<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;

class CustomerResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationLabel = 'Customer';

    protected static ?string $modelLabel = 'Customer';

    protected static ?string $pluralModelLabel = 'Customer';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Customer')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Perusahaan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn($livewire) => $livewire instanceof Pages\CreateCustomer)
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->helperText('Kosongkan jika tidak ingin mengubah password'),

                        Forms\Components\Hidden::make('role')
                            ->default('customer'),
                    ])->columns(2),

                Forms\Components\Section::make('Statistik Customer')
                    ->schema([
                        Forms\Components\Placeholder::make('total_containers')
                            ->label('Total Container')
                            ->content(fn($record) => $record ? $record->containers()->count() : 0),

                        Forms\Components\Placeholder::make('active_containers')
                            ->label('Container Aktif')
                            ->content(fn($record) => $record ? $record->containers()->whereIn('status', ['waiting', 'processing'])->count() : 0),

                        Forms\Components\Placeholder::make('completed_containers')
                            ->label('Container Selesai')
                            ->content(fn($record) => $record ? $record->containers()->where('status', 'completed')->count() : 0),

                        Forms\Components\Placeholder::make('total_penalties')
                            ->label('Total Denda')
                            ->content(function ($record) {
                                if (!$record) return 'Rp 0';
                                $total = $record->containers()->sum('jumlah_denda');
                                return 'Rp ' . number_format($total, 0, ',', '.');
                            }),
                    ])->columns(4)
                    ->visible(fn($livewire) => $livewire instanceof Pages\EditCustomer),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where('role', 'customer'))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('containers_count')
                    ->label('Total Container')
                    ->counts('containers')
                    ->alignCenter()
                    ->badge(),

                Tables\Columns\TextColumn::make('active_containers_count')
                    ->label('Container Aktif')
                    ->formatStateUsing(fn($record) => $record->containers()->whereIn('status', ['waiting', 'processing'])->count())
                    ->alignCenter()
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('completed_containers_count')
                    ->label('Container Selesai')
                    ->formatStateUsing(fn($record) => $record->containers()->where('status', 'completed')->count())
                    ->alignCenter()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('total_penalties')
                    ->label('Total Denda')
                    ->formatStateUsing(function ($record) {
                        $total = $record->containers()->sum('jumlah_denda');
                        if ($total > 0) {
                            return 'Rp ' . number_format($total, 0, ',', '.');
                        }
                        return '-';
                    })
                    ->alignRight()
                    ->color(fn($record) => $record->containers()->sum('jumlah_denda') > 0 ? 'danger' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_active_containers')
                    ->label('Memiliki Container Aktif')
                    ->query(fn(Builder $query): Builder => $query->whereHas('containers', fn(Builder $query) => $query->whereIn('status', ['waiting', 'processing']))),

                Tables\Filters\Filter::make('has_penalties')
                    ->label('Memiliki Denda')
                    ->query(fn(Builder $query): Builder => $query->whereHas('containers', fn(Builder $query) => $query->where('jumlah_denda', '>', 0))),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalWidth('4xl'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view_containers')
                    ->label('Lihat Container')
                    ->icon('heroicon-o-cube')
                    ->color('info')
                    ->url(fn($record) => "/admin/containers?tableFilters[customer_id][value]={$record->id}")
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('containers');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContainersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
