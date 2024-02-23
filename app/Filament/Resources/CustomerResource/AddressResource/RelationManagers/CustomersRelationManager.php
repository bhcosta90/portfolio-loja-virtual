<?php

namespace App\Filament\Resources\CustomerResource\AddressResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CustomersRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('zipcode')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(12),
                Forms\Components\Select::make('state')
                    ->placeholder(__('Select an option'))
                    ->options([
                        'AC' => 'Acre',
                        'AL' => 'Alagoas',
                        'AP' => 'Amapá',
                        'AM' => 'Amazonas',
                        'BA' => 'Bahia',
                        'CE' => 'Ceará',
                        'DF' => 'Distrito Federal',
                        'ES' => 'Espírito Santo',
                        'GO' => 'Goiás',
                        'MA' => 'Maranhão',
                        'MT' => 'Mato Grosso',
                        'MS' => 'Mato Grosso do Sul',
                        'MG' => 'Minas Gerais',
                        'PA' => 'Pará',
                        'PB' => 'Paraíba',
                        'PR' => 'Paraná',
                        'PE' => 'Pernambuco',
                        'PI' => 'Piauí',
                        'RJ' => 'Rio de Janeiro',
                        'RN' => 'Rio Grande do Norte',
                        'RS' => 'Rio Grande do Sul',
                        'RO' => 'Rondônia',
                        'RR' => 'Roraima',
                        'SC' => 'Santa Catarina',
                        'SP' => 'São Paulo',
                        'SE' => 'Sergipe',
                        'TO' => 'Tocantins',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(120),
                Forms\Components\TextInput::make('neighborhood')
                    ->required()
                    ->maxLength(120),
                Forms\Components\TextInput::make('street')
                    ->required()
                    ->maxLength(120),
                Forms\Components\TextInput::make('number')
                    ->numeric()
                    ->minValue(1),
                Forms\Components\TextInput::make('complement')
                    ->maxLength(120),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('street')->label(__('Street')),
                Tables\Columns\TextColumn::make('zipcode')->label(__('Zipcode')),
                Tables\Columns\TextColumn::make('city')->label(__('City')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function canCreate(): bool
    {
        return true;
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('zipcode'),
                TextEntry::make('state'),
                TextEntry::make('city'),
                TextEntry::make('street'),
                TextEntry::make('complement'),
            ])
            ->columns(1)
            ->inlineLabel();
    }

    protected static function getRecordLabel(): ?string
    {
        return __('address');
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Address');
    }
}
