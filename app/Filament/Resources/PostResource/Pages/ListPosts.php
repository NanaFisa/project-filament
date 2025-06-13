<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Filament\Resources\PostResource\Widgets\PostCounterWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Livewire\Livewire;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    // public function render(): View {
    //     return view('filament.resources.post-resource.pages.list-posts')->layout('filament::components.layouts.app');
    // }

    protected function getHeaderActions(): array
    { //for button like create/edit
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array {
        return [ //display component or Livewire UI
            PostCounterWidget::class,
        ];
    }

}
