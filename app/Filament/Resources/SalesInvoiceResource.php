<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesInvoiceResource\Pages;
use App\Models\FinishProduct;
use App\Models\SalesInvoice;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceResource extends Resource
{
    protected static ?string $model = SalesInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-report';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make([
                    Forms\Components\TextInput::make('invoice_number')
                        ->default('INV-' . random_int(100_000, 999_999))
                        ->unique(ignorable: fn ($record) => $record)
                        ->disabled()
                        ->required(),
                    Forms\Components\Select::make('customer_id')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\DatePicker::make('date')
                        ->required()
                        ->default(now()),
                    Forms\Components\Select::make('payment_type')
                        ->options([
                            'cash' => 'Cash',
                            'credit' => 'Credit',
                        ])->required(),
                    Forms\Components\Select::make('payment_status')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                        ])->required(),
                    Forms\Components\TextInput::make('discount')
                        ->numeric()
                        ->minValue(0),
                ]),
                Forms\Components\Card::make([
                    Forms\Components\Repeater::make('finishProductSalesInvoice')
                        ->label('Finish Product')
                        ->disabledOn(Pages\EditSalesInvoice::class)
                        ->defaultItems(1)
                        ->relationship()
                        ->columns(6)
                        ->schema([
                            Forms\Components\Select::make('finish_product_id')
                                ->label('Finish Product')
                                ->options(FinishProduct::query()->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->reactive()
                                ->columnSpan(3)
                                ->afterStateUpdated(function (Closure $set, $state, Closure $get) {
                                    $finishProduct = FinishProduct::find($state);
                                    $set('finish_product_id', $state);

                                    if ($finishProduct) {
                                        $set('finish_product_price', $get('finish_product_quantity') * $finishProduct->sales_price);
                                    }
                                })->required(),
                            Forms\Components\Hidden::make('finish_product_id'),
                            Forms\Components\TextInput::make('finish_product_quantity')
                                ->numeric()
                                ->minValue(1)
                                ->default(1)
                                ->reactive()
                                ->columnSpan(1)
                                ->afterStateUpdated(function (Closure $get, Closure $set) {
                                    $finishProduct = FinishProduct::find($get('product_id') || $get('finish_product_id'));

                                    if ($finishProduct) {
                                        $set('finish_product_price', $get('finish_product_quantity') * $finishProduct->sales_price);
                                    }
                                })->required(),
                            Forms\Components\TextInput::make('finish_product_price')
                                ->reactive()
                                ->disabled()
                                ->columnSpan(2)
                                ->required(),
                        ]),
                ]),
                Forms\Components\Card::make([
                    Forms\Components\FileUpload::make('receipt'),
                    Forms\Components\Textarea::make('invoice_notes'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('payment_type'),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                    ]),
                Tables\Columns\TextColumn::make('sub_total')
                    ->getStateUsing(function (Model $record) {
                        $items = [];
                        foreach ($record->finishProductSalesInvoice as $finishProduct) {
                            $items[] = ($finishProduct->finish_product_price * $finishProduct->finish_product_quantity)
                                - $record->discount;
                        }
                        return array_sum($items);
                    }),
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
            'index' => Pages\ListSalesInvoices::route('/'),
            'create' => Pages\CreateSalesInvoice::route('/create'),
            'edit' => Pages\EditSalesInvoice::route('/{record}/edit'),
        ];
    }
}
