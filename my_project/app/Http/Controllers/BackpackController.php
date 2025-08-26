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
use App\Models\Backpack as Sac;
use App\Services\BackpackService;

use App\Models\Item;
use Inertia\Inertia;

    
class BackpackController extends Controller
{   

    // Fonction de test avec la poo
    public function testShow ()
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

    public function index($id)
    {
        $backpack = Sac::with('items')->findOrFail($id);

        return Inertia::render('Backpack/Index', [
            'backpack' => $backpack
        ]);
    }
    
    // Pour savoir si le sac existe déjà ou non
    public function home()
    {
        $backpack = Sac::with('items')->findOrFail(1);
        if (!$backpack) {
            return Inertia::render('Backpack/Home', [
                'Message' => "Sac à dos non trouvé"
            ]);
        }
        return Inertia::render('Backpack/Home', [
            'backpack' => $backpack
        ]);
    }

    // Obtenir les items d'un sac à dos en particulier
    public function show($id)
    {
        $backpack = Sac::with('items')->findOrFail($id);

        return response()->json($backpack);
    }

    public function create(Request $request)
    {
        $backpackRequest = new Backpack($request->input('max_weight'), $request->input('max_volume'));
        
        $backpack = Sac::create([
            'max_weight' => $backpackRequest->getMaxWeight(),
            'max_volume' => $backpackRequest->getMaxVolume(),
        ]);

        return response()->json($backpack, 201);
    }
    
    // Ici on vide seulement le sac
    public function empty($id)
    {
        $backpack = Sac::findOrFail($id);
        $backpack->items()->delete();
        $backpack->weight = 0;
        $backpack->volume = 0;
        $backpack->save();

        return response()->json(['message' => "Le sac a été vidé"]);
    }


}
