<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Backpack as Sac;
use App\Models\Item;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Gourde', 'Couteau', 'Boussole', 'Trousse','Briquet', 'Carte', 'Rations','SacDeCouchage', 'Amadou', 'MateriauxTorche'];
        $type = $this->faker->randomElement($types);

        $base = [
            'name' => ucfirst($type) . ' ' . $this->faker->word(),
            'type' => $type,
            'weight' => $this->faker->randomFloat(1, 0.1, 5),
            'volume' => $this->faker->randomFloat(1, 0.1, 5),
            'backpack_id' => 1,
        ];

        switch ($type) {
            case 'Gourde':
                $base['quantity_cl'] = $this->faker->numberBetween(10, 100);
                break;
            case 'Couteau':
            case 'Briquet':
                $base['wear'] = $this->faker->numberBetween(0, 100);
                break;
            case 'Trousse':
            case 'Rations':
            case 'Amadou':
            case 'MateriauxTorche':
                $base['quantity'] = $this->faker->numberBetween(1, 10);
                break;
        }

        return $base;
    }
}
