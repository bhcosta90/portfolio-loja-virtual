<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'customer_id' => $customer = Customer::factory()->create()->id,
            'address_id' => Customer::factory()->create(['customer_id' => $customer]),
            'shipping' => $this->faker->randomNumber(),
        ];
    }
}
