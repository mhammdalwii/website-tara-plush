<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Manajemen Jadwal & Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Kegiatan'),

                Forms\Components\DateTimePicker::make('schedule_date')
                    ->required()
                    ->label('Tanggal & Waktu Pelaksanaan'),

                Forms\Components\TextInput::make('location')
                    ->required()
                    ->maxLength(255)
                    ->label('Lokasi'),

                Forms\Components\TextInput::make('target_audience')
                    ->maxLength(255)
                    ->label('Sasaran Peserta')
                    ->helperText('Contoh: Balita, Ibu Hamil, Lansia'),

                Forms\Components\RichEditor::make('description')
                    ->label('Deskripsi Lengkap')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Nama Kegiatan'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->label('Lokasi'),
                Tables\Columns\TextColumn::make('schedule_date')
                    ->dateTime()
                    ->sortable()
                    ->label('Jadwal'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
