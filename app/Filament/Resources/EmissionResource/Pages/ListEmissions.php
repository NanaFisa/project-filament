<?php

namespace App\Filament\Resources\EmissionResource\Pages;

use App\Filament\Resources\EmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListEmissions extends ListRecords
{
    protected static string $resource = EmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array {
        return [
            null => Tab::make('All')->query(fn ($query) => $query),
            'scope_1'=> Tab::make()->query(fn ($query) => $query-> where('scope', 'scope_1')),
            'scope_2'=> Tab::make()->query(fn ($query) => $query->where('scope', 'scope_2')),
            'scope_3'=> Tab::make()->query(fn ($query) => $query->where('scope', 'scope_3')),
        ];
    }
}
