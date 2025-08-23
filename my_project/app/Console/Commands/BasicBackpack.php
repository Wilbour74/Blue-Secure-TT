<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Backpack;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use App\Entities\WaterBottle as Gourde;
use App\Entities\Knife as Couteau;
use App\Entities\Compass as Boussole;
use App\Entities\Map as Carte;

class BasicBackpack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:basic-backpack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creation d\'un sac à dos avec des objets basique';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Item::truncate();
        Backpack::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $backpack = Backpack::create([
            'name' => 'Sac de l’aventurier',
            'max_weight' => 15,
            'max_volume' => 15,
        ]);

        $gourde = new Gourde("Gourde basique", 0.5, 1.0, 5.0);
        $couteau = new Couteau("Couteau de chasse", 0.5, 0.2, 100);
        $boussole = new Boussole("Boussole Indienne", 0.2, 0.1);
        $carte = new Carte("Carte de la guadeloupe", 0.2, 0.2);

        $items = [$gourde, $couteau, $boussole, $carte];

        foreach ($items as $item) {
            $data = $item->getItem();
            $data['backpack_id'] = $backpack->id;
            $backpack->items()->create($data);
        }

        $this->info("Sac à dos et items créés avec succès !");


    }
}
