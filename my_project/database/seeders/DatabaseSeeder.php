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

        // Supprimé et créer un nouveau sac puis ajouter des items aleatoires
        
        $sac = Sac::find(1);

        if(!$sac){
            $sac = Sac::create([
                'id' => 1,
                'max_weight' => 15,
                'max_volume' => 15,
                'weight' => 0,
                'volume' => 0,
            ]);
        }
        
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
