<?php

namespace App\Filament\Clusters\Products\CategoryResource\Pages;

use App\Filament\Clusters\Products\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
