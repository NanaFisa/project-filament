<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmissionResource\Pages;
use App\Filament\Resources\EmissionResource\RelationManagers;
use App\Models\Emission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{Grid, Select, TextInput, Repeater, Section, Group, Placeholder};
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;

class EmissionResource extends Resource
{
    protected static ?string $model = Emission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)->schema([
                    Group::make()->schema([
                        Section::make('Basic Information')
                            ->description('Enter the basic emission details')
                            ->schema([
                                Select::make('scope_id')
                                    ->label('Scope')
                                    ->relationship('scope', 'name')
                                    ->required()
                                    ->preload()
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Categories')
                            ->description('Add categories and sub-categories for this emission')
                            ->schema([
                                Repeater::make('categories')
                                    ->relationship('categories')
                                    ->label('Main Categories')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Category Name')
                                            ->required()
                                            ->columnSpanFull(),

                                        Group::make()
                                            ->label('Activities')
                                            ->schema([
                                                Repeater::make('activities')
                                                    ->relationship('activities')
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->label('Activity Name')
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->dehydrated(fn($state) => filled($state['name'] ?? null))
                                                    ->addActionLabel('Add Activity')
                                                    ->columns(1),
                                            ]),
                                    ])
                                    ->addActionLabel('Add Main Category')
                                    ->columns(1)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(8),

                    Group::make([
                        Section::make(
                            'Record Metadata'
                        )->schema([
                            Placeholder::make('created_at')->label('Created At')
                                ->content(fn($record) => $record?->created_at?->format('d M Y, H:i'))->visibleOn('edit'),

                            Placeholder::make('updated_at')->label('Updated At')
                                ->content(fn($record) => $record?->updated_at?->format('d M Y, H:i'))->visibleOn('edit'),
                        ]),

                    ])->columnSpan(4),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scope.name')
                    ->label('Scope')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'scope_1' => 'danger',
                        'scope_2' => 'warning',
                        'scope_3' => 'success',
                        default => 'gray',
                    })
                    ->sortable()
                    ->badge(),

                TextColumn::make('categories_count')
                    ->counts('categories')
                    ->label('Categories')
                    ->sortable(),

                TextColumn::make('activity_count')
                    ->label('Sub-Categories')
                    ->getStateUsing(fn($record) => $record->categories->flatMap->activities->count())
                    ->sortable(),

                TextColumn::make('categories_list')
                    ->label('Category Names')
                    ->getStateUsing(fn($record) => $record->categories->pluck('name')->implode(', '))
                    ->limit(50)
                    ->tooltip(fn($record) => $record->categories->pluck('name')->implode(', ')),
            ])
            ->filters([
            ])
            ->actions([
                Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->modalheading('Preview Emission Record')
                ->modalButton('Close')
                ->modalContent(fn ($record) => view('filament.resources.emission-resource.preview', [
                    'record' => $record,
                ])),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmissions::route('/'),
            'create' => Pages\CreateEmission::route('/create'),
            'edit' => Pages\EditEmission::route('/{record}/edit'),
        ];
    }


    public static function getScopeFormSchema(): array
    {
        return [
            Select::make('scope_id')
                ->label('Scope')
                ->relationship('scope', 'name')
                ->preload()
                ->searchable()
                ->required(),
        ];
    }


    // public static function getCategoriesFormSchema(): array
    // {
    //     return [
    //             TextInput::make('category.name')
    //                     ->label('Category Name')
    //                     ->required(),

    //             Section::make('Activity Deatils')
    //             ->schema([
    //             TextInput::make('activity.name')
    //                             ->label('Activity Category Name'),

    //             TextInput::make('activity.type')
    //                 ->label('Type')
    //                 ->required(),

    //             TextInput::make('activity.unit')
    //                 ->label('Unit')
    //                 ->required(),

    //             TextInput::make('activity.emission_factor')
    //                 ->label('Emission Factor')
    //                 ->numeric()
    //                 ->required(),

    //             TextInput::make('activity.source')
    //                 ->label('Source'),

    //             TextInput::make('activity.year')
    //                 ->label('Year')
    //                 ->numeric()
    //                 ->minValue(1900)
    //                 ->maxValue(date('Y')),

    //         ])
    //     ];
    // }
    public static function getCategoriesFormSchema(): array
{
    return [
        Repeater::make('categories')
            ->relationship('categories')
            ->label('Main Categories')
            ->schema([
                TextInput::make('name')
                    ->label('Category Name')
                    ->required(),

                TextInput::make('description')
                    ->label('Description')
                    ->nullable(),

                Repeater::make('activities')
                    ->relationship('activities')
                    ->label('Activity Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Activity Name')
                            ->required(),

                        TextInput::make('type')
                            ->label('Type')
                            ->nullable(),

                        TextInput::make('unit')
                            ->label('Unit')
                            ->nullable(),

                        TextInput::make('emission_factor')
                            ->label('Emission Factor')
                            ->numeric()
                            ->step(0.0001)
                            ->nullable(),

                        TextInput::make('source')
                            ->label('Source')
                            ->nullable(),

                        TextInput::make('year')
                            ->label('Year')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(now()->year)
                            ->nullable(),
                    ])
                    ->addActionLabel('Add Activity')
                    ->columns(2)
                    ->maxItems(1)
            ])
            ->addActionLabel('Add Category')
            ->columns(1)
            ->maxItems(1),
    ];
}

}
