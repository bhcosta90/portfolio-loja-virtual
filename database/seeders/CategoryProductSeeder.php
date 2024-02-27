<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Arr;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::pluck('id')->toArray();
        Product::get()->map(
            fn ($product) => $product->categories()->attach(Arr::random($categories, random_int(2, 4)))
        );
    }
}
