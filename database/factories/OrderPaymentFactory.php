<?php

namespace Database\Factories;

use App\Models\OrderPayment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderPaymentFactory extends Factory
{
    protected $model = OrderPayment::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'type' => $this->faker->word(),
            'value' => $this->faker->randomNumber(),
            'credit_card_name' => $this->faker->name(),
            'credit_card_number' => $this->faker->word(),
            'credit_card_month' => $this->faker->word(),
            'credit_card_year' => $this->faker->word(),
            'credit_card_cvc' => $this->faker->word(),
        ];
    }
}
