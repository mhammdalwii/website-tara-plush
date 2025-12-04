<?php

namespace App\Filament\Resources\BalitaResource\Pages;

use App\Filament\Resources\BalitaResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms; // <-- Pastikan ini ada

class CreateBalita extends CreateRecord
{
    protected static string $resource = BalitaResource::class;

    // Method ini akan menambahkan form pengukuran HANYA di halaman "New Balita"
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informasi Induk')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Orang Tua (Pengguna)')
                        ->options(\App\Models\User::where('is_admin', false)->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ]),
            Forms\Components\Section::make('Data Diri Balita')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->label('Nama Balita'),
                    Forms\Components\DatePicker::make('date_of_birth')->required()->label('Tanggal Lahir'),
                    Forms\Components\Select::make('gender')->required()->options(['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'])->label('Jenis Kelamin'),
                    Forms\Components\Textarea::make('address')->required()->label('Alamat')->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Data Pengukuran Pertama')
                ->description('Masukkan data pengukuran pertama untuk balita ini.')
                ->schema([
                    Forms\Components\DatePicker::make('measurement_date')->required()->label('Tanggal Pengukuran')->default(now()),
                    Forms\Components\TextInput::make('height')->required()->numeric()->label('Tinggi (cm)')->suffix('cm'),
                    Forms\Components\TextInput::make('weight')->required()->numeric()->label('Berat (kg)')->suffix('kg'),
                    Forms\Components\TextInput::make('arm_circumference')->required()->numeric()->label('Lingkar Lengan (cm)')->suffix('cm'),
                    Forms\Components\TextInput::make('head_circumference')->required()->numeric()->label('Lingkar Kepala (cm)')->suffix('cm'),
                ])->columns(2),
        ];
    }

    // Method ini akan menyimpan data pengukuran ke tabel riwayat
    protected function afterCreate(): void
    {
        // Ambil data dari seluruh form
        $measurementData = $this->form->getState();

        // Buat record baru di tabel riwayat pengukuran, terhubung dengan balita yang baru saja dibuat
        $this->record->measurements()->create([
            'measurement_date' => $measurementData['measurement_date'],
            'height' => $measurementData['height'],
            'weight' => $measurementData['weight'],
            'arm_circumference' => $measurementData['arm_circumference'],
            'head_circumference' => $measurementData['head_circumference'],
        ]);
    }
}
