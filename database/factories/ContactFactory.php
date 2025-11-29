<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 2,   // fixed user id
            'name'    => $this->faker->name(),
            'email'   => $this->faker->unique()->safeEmail(),
            'phone'   => $this->faker->numerify('##########'),
            'address' => $this->faker->address(),
        ];
    }
}
