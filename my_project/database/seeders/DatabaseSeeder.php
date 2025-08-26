<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Backpack as Sac;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Item::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $sac = Sac::find(1);
        // Logique de 10 éléments pour le sac
        for ($i = 0; $i < 10; $i++) {
            $item = Item::factory()->make();

            $currentWeight = $sac->items()->sum('weight');
            $currentVolume = $sac->items()->sum('volume');

            if ($currentWeight + $item->weight <= $sac->max_weight &&
                $currentVolume + $item->volume <= $sac->max_volume) {
                $item->save();
            }
        }
        
        

        $sac->update([
            'weight' => $sac->items()->sum('weight'),
            'volume' => $sac->items()->sum('volume'),
        ]);       

    }
}
