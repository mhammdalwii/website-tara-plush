<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationPostResource\Pages;
use App\Models\EducationPost;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\TextColumn;
use App\Helpers\YouTubeHelper;
use Illuminate\Support\Str;

class EducationPostResource extends Resource
{
    protected static ?string $model = EducationPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Edukasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('Kategori'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('Judul Video'),

                // Slug hanya tampil, tapi tetap ikut dikirim ke backend
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(true)
                    ->default(fn($get) => Str::slug($get('title')))
                    ->helperText('Slug akan terisi otomatis setelah disimpan.'),

                TextInput::make('video_url')
                    ->required()
                    ->url()
                    ->label('URL Video YouTube')
                    ->helperText('Cukup tempelkan link video dari address bar atau tombol share.'),

                RichEditor::make('description')
                    ->label('Deskripsi Video')
                    ->columnSpanFull(),
            ]);
    }

    // Pastikan data terproses sebelum create
    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = !empty($data['slug'])
            ? $data['slug']
            : Str::slug($data['title']);

        $data['video_url'] = YouTubeHelper::getEmbedUrl($data['video_url']);
        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = !empty($data['slug'])
            ? $data['slug']
            : Str::slug($data['title']);

        $data['video_url'] = YouTubeHelper::getEmbedUrl($data['video_url']);
        return $data;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->label('Judul Video'),
                TextColumn::make('category.name')->sortable()->label('Kategori'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEducationPosts::route('/'),
            'create' => Pages\CreateEducationPost::route('/create'),
            'edit' => Pages\EditEducationPost::route('/{record}/edit'),
        ];
    }
}
