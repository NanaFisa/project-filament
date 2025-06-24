<?php

namespace App\Filament\Resources\EmissionResource\Pages;

use App\Filament\Resources\EmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmission extends EditRecord
{
    protected static string $resource = EmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
