<?php

namespace App\Filament\Clusters\Products\ProductResource\Pages;

use App\Filament\Clusters\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
