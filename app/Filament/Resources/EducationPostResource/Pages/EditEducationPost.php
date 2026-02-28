<?php

namespace App\Filament\Resources\EducationPostResource\Pages;

use App\Filament\Resources\EducationPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEducationPost extends EditRecord
{
    protected static string $resource = EducationPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
