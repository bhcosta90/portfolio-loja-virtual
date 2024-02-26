<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Illuminate\Contracts\Support\Htmlable;

class Products extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    //    protected static ?string $slug = 'shop/products';

    public static function getNavigationGroup(): ?string
    {
        return __('Shop');
    }

    public static function getNavigationLabel(): string
    {
        return \ucfirst(__('product'));
    }

    public function getTitle(): string|Htmlable
    {
        return 'oi';
    }
}
