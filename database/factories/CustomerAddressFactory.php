<?php

namespace Database\Factories;

use App\Models\CustomerAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CustomerAddressFactory extends Factory
{
    protected $model = CustomerAddress::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'zipcode' => $this->faker->word(),
            'state' => $this->faker->word(),
            'city' => $this->faker->city(),
            'neighborhood' => $this->faker->word(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->word(),
            'complement' => $this->faker->word(),
            'country' => $this->faker->country(),
        ];
    }
}
