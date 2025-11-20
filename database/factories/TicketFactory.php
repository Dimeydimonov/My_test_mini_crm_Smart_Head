<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;


class TicketFactory extends Factory
{

    public function definition(): array
    {
        return [
           'customer_id'=> Customer::factory(),
	        'subject'=> $this->faker->sentence(6),
	        'message'=> $this->faker->paragraph(3),
	        'status'=> $this->faker->randomElement(['new','in_progress', 'completed']),
	        'manager_response_date'=>null,
        ];
    }
}
