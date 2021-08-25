<?php

namespace Database\Factories;

use App\Models\Consumer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsumerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consumer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'prenom'    => $this->faker->firstName,
            'nom'       => $this->faker->lastName,
            'phone'     => $this->faker->unique()->phoneNumber,
            'ville'     => $this->faker->city,
            'adresse'   => $this->faker->address,
            'status'    => $this->faker->randomElement(['active','blocked']),
        ];
    }
}
