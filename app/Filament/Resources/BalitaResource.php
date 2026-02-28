<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BalitaResource\Pages;
use App\Filament\Resources\BalitaResource\RelationManagers;
use App\Models\Balita;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Filament\Actions;

class BalitaResource extends Resource
{
    protected static ?string $model = Balita::class;

    protected static ?string $modelLabel = 'Balita';
    protected static ?string $pluralModelLabel = 'Balita';
    protected static ?string $navigationLabel = 'Balita';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Induk')
                    ->schema([
                        // Dropdown untuk memilih orang tua dari daftar pengguna
                        Forms\Components\Select::make('user_id')
                            ->label('Orang Tua (Pengguna)')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ]),
                Forms\Components\Section::make('Data Balita')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Balita'),

                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required()
                            ->label('Tanggal Lahir'),

                        Forms\Components\Select::make('gender')
                            ->required()
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->label('Jenis Kelamin'),

                        Forms\Components\Textarea::make('address')
                            ->required()->label('Alamat')->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pengukuran')
                    ->schema([
                        Forms\Components\DatePicker::make('measurement_date')->required()->label('Tanggal Pengukuran'),
                        Forms\Components\TextInput::make('height')->required()->numeric()->label('Tinggi Badan (cm)'),
                        Forms\Components\TextInput::make('weight')->required()->numeric()->label('Berat Badan (kg)'),
                        Forms\Components\TextInput::make('arm_circumference')->required()->numeric()->label('Lingkar Lengan (cm)'),
                        Forms\Components\TextInput::make('head_circumference')->required()->numeric()->label('Lingkar Kepala (cm)'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Balita'),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->label('Orang Tua'),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->label('Tanggal Lahir'),
                Tables\Columns\TextColumn::make('height')
                    ->numeric()
                    ->sortable()
                    ->label('Tinggi (cm)'),
                Tables\Columns\TextColumn::make('weight')
                    ->numeric()
                    ->sortable()
                    ->label('Berat (kg)'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Data Balita')
                    ->modalDescription('Apakah kamu yakin ingin menghapus data balita ini? Tindakan ini tidak bisa dibatalkan.')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MeasurementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBalitas::route('/'),
            'create' => Pages\CreateBalita::route('/create'),
            'edit' => Pages\EditBalita::route('/{record}/edit'),
        ];
    }
}
