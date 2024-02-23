<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Products extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

//    protected static ?string $slug = 'shop/products';

    public static function getNavigationGroup(): ?string
    {
        return __('Shop');
    }
}
