<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationLabel = 'Daftar Pengguna';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengguna')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap'),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Alamat Email'),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->label('Nomor Telepon'),

                        // Toggle untuk menentukan Admin atau bukan
                        Forms\Components\Toggle::make('is_admin')
                            ->label('Akses Admin')
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Jika aktif, pengguna ini bisa masuk ke dashboard admin.'),
                    ])->columns(2),

                Forms\Components\Section::make('Keamanan')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->label('Password')
                            ->helperText('Kosongkan jika tidak ingin mengubah password.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),

                // Menampilkan status Admin dengan ikon warna
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->label('Admin')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter untuk melihat siapa saja yang Admin
                Tables\Filters\TernaryFilter::make('is_admin')
                    ->label('Hanya Admin'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
