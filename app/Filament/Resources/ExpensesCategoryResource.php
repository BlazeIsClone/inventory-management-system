<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesCategoryResource\Pages;
use App\Models\ExpenseCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ExpensesCategoryResource extends Resource
{
    protected static ?string $model = ExpenseCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Expenditure';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('name')
                        ->unique(ignorable: fn ($record) => $record),
                    Forms\Components\Toggle::make('is_included_in_total_expenses')
                        ->default(true),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_included_in_total_expenses')
                    ->boolean(),
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
            'index' => Pages\ListExpensesCategories::route('/'),
            'create' => Pages\CreateExpensesCategory::route('/create'),
            'view' => Pages\ViewExpensesCategory::route('/{record}'),
            'edit' => Pages\EditExpensesCategory::route('/{record}/edit'),
        ];
    }
}
