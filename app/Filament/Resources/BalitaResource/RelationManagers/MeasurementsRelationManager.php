<?php

namespace App\Filament\Resources\BalitaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MeasurementsRelationManager extends RelationManager
{
    protected static string $relationship = 'measurements';
    protected static ?string $recordTitleAttribute = 'measurement_date';

    public function form(Form $form): Form
    {
        // Di sini kita definisikan semua field untuk form popup
        return $form
            ->schema([
                Forms\Components\DatePicker::make('measurement_date')
                    ->required()
                    ->label('Tanggal Pengukuran'),

                Forms\Components\TextInput::make('height')
                    ->required()
                    ->numeric()
                    ->label('Tinggi Badan (cm)')
                    ->suffix('cm'),

                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->numeric()
                    ->label('Berat Badan (kg)')
                    ->suffix('kg'),

                Forms\Components\TextInput::make('arm_circumference')
                    ->required()
                    ->numeric()
                    ->label('Lingkar Lengan (cm)')
                    ->suffix('cm'),

                Forms\Components\TextInput::make('head_circumference')
                    ->required()
                    ->numeric()
                    ->label('Lingkar Kepala (cm)')
                    ->suffix('cm'),
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('measurement_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('height')->suffix(' cm'),
                Tables\Columns\TextColumn::make('weight')->suffix(' kg'),
            ])
            ->filters([])
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
            ]);
    }
}
