<?php

namespace App\Filament\Clusters\Products;

use App\Filament\Clusters\Products;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $cluster = Products::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 0;

    public static function getLabel(): ?string
    {
        return __('product');
    }

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
                    Forms\Components\Section::make('Images')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                                ->collection('product-images')
                                ->multiple()
                                ->maxFiles(5)
                                ->image()
                                ->hiddenLabel(),
                        ])
                        ->collapsed()
                        ->collapsible(),
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
                                ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),

                            Forms\Components\TextInput::make('price_cost')
                                ->label(__('Cost per item'))
                                ->helperText(__('Customers won\'t see this price.'))
                                ->numeric()
                                ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/']),
                        ])
                        ->columns(),
                    Forms\Components\Section::make(__('Shipping'))
                        ->schema([
                            Forms\Components\Checkbox::make('backorder')
                                ->label(__('This product can be returned')),

                            Forms\Components\Checkbox::make('requires_shipping')
                                ->label(__('This product will be shipped')),
                        ])
                        ->columns(),
                ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make([
                    Forms\Components\Section::make(__('Status'))
                        ->schema([
                            Forms\Components\Toggle::make('is_visible')
                                ->label(__('Visible'))
                                ->helperText(__('This product will be hidden from all sales channels.'))
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
                                ->label(__('Categories'))
                                ->relationship('categories', 'name')
                                ->multiple(),
                        ]),
                ]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('product-image')
                    ->label('Image')
                    ->collection('product-images'),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label(__('Brand'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label(__('Visibility'))
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('price_actual')
                    ->label(__('Price'))
                    ->searchable()
                    ->sortable(),

                //                Tables\Columns\TextColumn::make('sku')
                //                    ->label('SKU')
                //                    ->searchable()
                //                    ->sortable()
                //                    ->toggleable(),
                //
                //                Tables\Columns\TextColumn::make('qty')
                //                    ->label('Quantity')
                //                    ->searchable()
                //                    ->sortable()
                //                    ->toggleable(),
                //
                //                Tables\Columns\TextColumn::make('security_stock')
                //                    ->searchable()
                //                    ->sortable()
                //                    ->toggleable()
                //                    ->toggledHiddenByDefault(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('Publish Date'))
                    ->date()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            'index' => Products\ProductResource\Pages\ListProducts::route('/'),
            'create' => Products\ProductResource\Pages\CreateProduct::route('/create'),
            'edit' => Products\ProductResource\Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
