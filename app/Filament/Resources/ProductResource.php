<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Products;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Products::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->minValue(1)
                            ->string()
                            ->label(__('Name'))
                            ->columnSpanFull(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label(__('Description'))
                            ->columnSpanFull(),
                    ])->columns(2),
                    Forms\Components\Section::make(__('Pricing'))
                        ->schema([
                            Forms\Components\TextInput::make('price_actual')
                                ->label(__('Price'))
                                ->numeric()
                                ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                ->required()
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('price_old')
                                ->label(__('Compare at price'))
                                ->numeric()
                                ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                ->required(),

                            Forms\Components\TextInput::make('price_cost')
                                ->label('Cost per item')
                                ->helperText('Customers won\'t see this price.')
                                ->numeric()
                                ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                                ->required(),
                        ])
                        ->columns(),
                    Forms\Components\Section::make(__('Shipping'))
                        ->schema([
                            Forms\Components\Checkbox::make('backorder')
                                ->label(__('This product can be returned')),

                            Forms\Components\Checkbox::make('requires_shipping')
                                ->label(__('This product will be shipped')),
                        ])
                        ->columns()
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make([
                    Forms\Components\Section::make(__('Status'))
                        ->schema([
                            Forms\Components\Toggle::make('is_visible')
                                ->label(__('Visible'))
                                ->helperText('This product will be hidden from all sales channels.')
                                ->default(true),

                            Forms\Components\DatePicker::make('published_at')
                                ->label(__('Availability'))
                                ->default(now())
                                ->required(),
                        ]),

                    Forms\Components\Section::make(__('Associations'))
                        ->schema([
                            Forms\Components\Select::make('brand_id')
                                ->label(__('Brand'))
                                ->relationship('brand', 'name')
                                ->searchable(),

                            Forms\Components\Select::make('categories')
                                ->relationship('categories', 'name')
                                ->multiple()
                        ])
                ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name'))->searchable(),
                Tables\Columns\TextColumn::make('price_actual')->label(__('Price')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->defaultSort('name');
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
