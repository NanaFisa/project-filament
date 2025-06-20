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
                                Select::make('scope')
                                    ->label('Scope')
                                    ->options([
                                        'scope_1' => 'Scope 1',
                                        'scope_2' => 'Scope 2',
                                        'scope_3' => 'Scope 3',
                                    ])
                                    ->required()
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
                                            ->label('Child Categories')
                                            ->schema([
                                                Repeater::make('childCategories')
                                                    ->relationship('childCategories')
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->label('Child Category Name')
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->dehydrated(fn($state) => filled($state['name'] ?? null))
                                                    ->addActionLabel('Add Child Category')
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
                TextColumn::make('scope')
                    ->label('Scope')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'scope_1' => 'danger',
                        'scope_2' => 'warning',
                        'scope_3' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                // TextColumn::make('created_at')
                //     ->label('Created')
                //     ->dateTime('d M Y, H:i')
                //     ->sortable(),

                TextColumn::make('categories_count')
                    ->counts('categories')
                    ->label('Categories')
                    ->sortable(),

                TextColumn::make('child_categories_count')
                    ->label('Sub-Categories')
                    ->getStateUsing(fn($record) => $record->categories->flatMap->childCategories->count())
                    ->sortable(),

                TextColumn::make('categories_list')
                    ->label('Category Names')
                    ->getStateUsing(fn($record) => $record->categories->pluck('name')->implode(', '))
                    ->limit(50)
                    ->tooltip(fn($record) => $record->categories->pluck('name')->implode(', ')),
            ])
            ->filters([
                // Tables\Filters\SelectFilter::make('scope')
                //     ->options([
                //         'scope_1' => 'Scope 1',
                //         'scope_2' => 'Scope 2',
                //         'scope_3' => 'Scope 3',
                //     ])
                //     ->label('Filter by Scope'),
            ])
            ->actions([
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
            Select::make('scope')
                ->label('Scope')
                ->options([
                    'scope_1' => 'Scope 1',
                    'scope_2' => 'Scope 2',
                    'scope_3' => 'Scope 3',
                ])
                ->required(),
        ];
    }


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

                    Repeater::make('childCategories')
                        ->relationship('childCategories')
                        ->schema([
                            TextInput::make('name')
                                ->label('Child Category Name'),
                        ])
                        ->addActionLabel('Add Child Category')
                        ->columns(1),
                ])
                ->addActionLabel('Add Main Category')
                ->columns(1),
        ];
    }
}
