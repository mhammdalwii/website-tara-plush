<?php

namespace App\Filament\Resources\EducationPostResource\Pages;

use App\Filament\Resources\EducationPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEducationPosts extends ListRecords
{
    protected static string $resource = EducationPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
