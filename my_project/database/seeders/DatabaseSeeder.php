<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Backpack as Sac;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sac::factory(5)->create()->each(function ($sac){
            for ($i = 0; $i < 10; $i++) {
                $itemData = Item::factory()->make();

                // Somme réelle depuis la base
                $currentWeight = $sac->items()->sum('weight');
                $currentVolume = $sac->items()->sum('volume');

                if ($currentWeight + $itemData->weight <= $sac->max_weight &&
                    $currentVolume + $itemData->volume <= $sac->max_volume) {

                    $itemData->backpack_id = $sac->id;
                    $itemData->save();
                }
            }

            // Mettre à jour le poids et volume total du sac
            $sac->update([
                'weight' => $sac->items()->sum('weight'),
                'volume' => $sac->items()->sum('volume'),
            ]);
        });

    }
}
