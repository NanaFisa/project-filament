<?php

namespace App\Filament\Resources\EmissionResource\Pages;

use App\Filament\Resources\EmissionResource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\View\View;

class CreateEmission extends CreateRecord
{
    protected static string $resource = EmissionResource::class;

    protected function afterCreate(): void
    {

        $record = $this->record;

        Notification::make()
            ->title('New Scope')
           // ->icon('heroicon-o-shopping-bag')
            ->body("**{$record->scope}** was added successfully")
            ->send();
    }


    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
            ->schema([

            Wizard::make([
                Wizard\Step::make('Choose or Add New Scope')
                    ->schema(EmissionResource::getScopeFormSchema()),

                Wizard\Step::make('Add Categories & Activity')
                    ->schema(EmissionResource::getCategoriesFormSchema()),
            ])
                ->submitAction($this->getSubmitFormAction())

             ])->columns(1)
        ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }
}
