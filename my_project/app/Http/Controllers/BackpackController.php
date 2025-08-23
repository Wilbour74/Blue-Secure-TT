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

    public function add(Request $request)
    {
        $data = $request->all();

        switch ($data['type']) {
            case 'Gourde':
                $item = new Gourde($data['name'], $data['weight'], $data['volume'], $data['capacity']);
                break;
            case 'Couteau':
                $item = new Couteau($data['name'], $data['weight'], $data['volume'], $data['durability']);
                break;
            case 'Boussole':
                $item = new Boussole($data['name'], $data['weight'], $data['volume']);
                break;
            case 'Trousse':
                $item = new Trousse($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;
            case 'Briquet':
                $item = new Briquet($data['name'], $data['weight'], $data['volume']);
                break;
            case 'Carte':
                $item = new Carte($data['name'], $data['weight'], $data['volume']);
                break;
            case 'Rations':
                $item = new Rations($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;
            case 'SacDeCouchage':
                $item = new SacDeCouchage($data['name'], $data['weight'], $data['volume']);
                break;
            case 'Amadou':
                $item = new Amadou($data['name'], $data['weight'], $data['volume']);
                break;
            case 'MateriauxTorche':
                $item = new MateriauxTorche($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;
            default:
                return response()->json(['error' => 'Type inconnu'], 400);
        }

        $backpack = new Backpack(15, 15);
        $backpack->addItems($item);

        return response()->json([
            'message' => 'Objet ajouté',
            'item' => [
                'name' => $item->getName(),
                'weight' => $item->getWeight(),
                'volume' => $item->getVolume(),
                'info' => $item->getDescription(),
                'quantity' => method_exists($item, 'getQuantity') ? $item->getQuantity() : (method_exists($item, 'getWear') ? $item->getWear() : null), 
            ]
        ]);
    }
}
