<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipeResource\Pages;
use App\Models\Recipe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Tabs;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Manajemen Resep';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Info Utama')

                            ->schema([
                                Forms\Components\Select::make('recipe_category_id')
                                    ->relationship('recipeCategory', 'name')
                                    ->required()
                                    ->label('Kategori Resep'),

                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->label('Nama Resep'),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->helperText('Slug otomatis dari judul.')
                                    ->unique(ignoreRecord: true),

                                // Ini adalah komponen untuk upload gambar
                                Forms\Components\FileUpload::make('image')
                                    ->label('Gambar Masakan')
                                    ->image()
                                    ->directory('recipe-images') // Folder penyimpanan
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                                    ->maxSize(2048),

                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Singkat')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('Detail Resep')
                            ->schema([
                                Forms\Components\TextInput::make('prep_time')
                                    ->numeric()->label('Waktu Persiapan (Menit)'),
                                Forms\Components\TextInput::make('cook_time')
                                    ->numeric()->label('Waktu Memasak (Menit)'),
                                Forms\Components\TextInput::make('servings')
                                    ->label('Jumlah Porsi'),
                            ])->columns(3),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Bahan & Cara Membuat')
                            ->schema([
                                Forms\Components\RichEditor::make('ingredients')
                                    ->required()->label('Bahan-bahan'),
                                Forms\Components\RichEditor::make('instructions')
                                    ->required()->label('Cara Membuat'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Menampilkan gambar di tabel
                Tables\Columns\ImageColumn::make('image')->label('Gambar'),
                Tables\Columns\TextColumn::make('title')->searchable()->label('Nama Resep'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
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

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // pastikan slug unik
        while (Recipe::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = static::generateUniqueSlug($data['title']);
        return $data;
    }

    protected static function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = static::generateUniqueSlug($data['title'], $data['id'] ?? null);
        return $data;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }
}
