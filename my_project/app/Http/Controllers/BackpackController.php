<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Compass as Boussole;
use App\Entities\Knife as Couteau;
use App\Entities\WaterBottle as Gourde;
use App\Entities\Kit as Trousse;
use App\Entities\Lighter as Briquet;
use App\Entities\Map as Carte;
use App\Entities\Rations;
use App\Entities\SleepingBag as SacDeCouchage;
use App\Entities\Tinder as Amadou;
use App\Entities\TorchKit as MateriauxTorche;
use App\Entities\Backpack;
use App\Services\BackpackService;

class BackpackController extends Controller
{
    public function show ()
    {
        $backpack = new Backpack(15,15);
        $service = new BackpackService($backpack);

        $gourde = new Gourde("Gourde", 0.5, 1.0, 5.0);
        $couteau = new Couteau("Couteau de chasse", 0.5, 15, 100);
        $boussole = new Boussole("Boussole", 0.2, 0.1);
        $backpack->addItems($gourde, $couteau, $boussole);

        return response()->json([
            'items' => $backpack->listItemsJson(),
            'weight' => $backpack->getWeight(),
            'volume' => $backpack->getVolume(),
        ]);

    }
}
