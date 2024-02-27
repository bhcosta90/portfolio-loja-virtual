<?php

namespace Database\Factories;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'product_id' => $this->faker->word(),
            'name' => $this->faker->name(),
            'value' => $this->faker->randomNumber(),
            'quantity' => $this->faker->randomNumber(),
        ];
    }
}
