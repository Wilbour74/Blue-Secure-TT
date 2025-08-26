<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Backpack as Sac;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sac>
 */
class BackpackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Sac::class;

    public function definition(): array
    {
        return [
            "weight" => 0,
            "volume" => 0,
            "max_weight" => $this->faker->numberBetween(10,25),
            "max_volume" => $this->faker->numberBetween(20,25),
        ];
    }
}
