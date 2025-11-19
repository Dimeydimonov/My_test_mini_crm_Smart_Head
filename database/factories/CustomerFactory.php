<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;


class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
	        'phone_number'=> $this->faker->e164PhoneNumber(),
	        'email' => $this->faker->unique() ->safeEmail(),
        ];
    }
}
