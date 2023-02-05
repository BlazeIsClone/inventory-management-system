<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinishProductResource\Pages;
use App\Models\FinishProduct;
use App\Models\RawProduct;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class FinishProductResource extends Resource
{
    protected static ?string $model = FinishProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Production';

    protected static ?int $navigationSort = 8;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('name')
                        ->unique(ignorable: fn ($record) => $record)
                        ->required(),
                    Forms\Components\TextInput::make('labour_percentage')
                        ->numeric(),
                    Forms\Components\TextInput::make('sales_price')
                        ->numeric()
                        ->required(),
                ]),
                Forms\Components\Card::make([
                    Forms\Components\Repeater::make('finishProductRawProducts')
                        ->label('Add Raw Product')
                        ->relationship()
                        ->defaultItems(1)
                        ->columns(3)
                        ->schema([
                            Forms\Components\Select::make('raw_product_id')
                                ->options(RawProduct::query()->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->columnSpan(2)
                                ->required(),
                            Forms\Components\TextInput::make('raw_product_quantity')
                                ->numeric()
                                ->minValue(1)
                                ->default(1)
                                ->columnSpan(1)
                                ->required(),
                        ]),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                //Tables\Columns\TagsColumn::make('finishProductRawProducts.name'),
                Tables\Columns\TextColumn::make('labour_percentage'),
                Tables\Columns\TextColumn::make('sales_price')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinishProducts::route('/'),
            'create' => Pages\CreateFinishProduct::route('/create'),
            'edit' => Pages\EditFinishProduct::route('/{record}/edit'),
        ];
    }
}
