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
use App\Http\Requests\AddItemRequest;
use App\Models\Item;

    
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

    // Obtenir les items d'un sac à dos en particulier
    public function show($id)
    {
        $backpack = Sac::with('items')->findOrFail($id);

        return response()->json($backpack);
    }


    // Ajouter un item dans le sac à dos
    public function add(AddItemRequest $request)
    {
        $data = $request->validated();
        // Boucle pour créer l'objet en fonction du type
        switch ($data['type']) {
            case 'Gourde':
                $item = new Gourde($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;
            case 'Couteau':
                $item = new Couteau($data['name'], $data['weight'], $data['volume'], $data['wear']);
                break;
            case 'Boussole':
                $item = new Boussole($data['name'], $data['weight'], $data['volume']);
                break;
            case 'Trousse':
                $item = new Trousse($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;
            case 'Briquet':
                $item = new Briquet($data['name'], $data['weight'], $data['volume'], $data['wear']);
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

        $backpack = Sac::latest()->first();

        if (!$backpack) {
            $backpack = Sac::create([
                'name' => 'Sac de l’aventurier',
                'max_weight' => 15,
                'max_volume' => 15,
            ]);
        }

        // Calculer le nouveau poids et volume du sac à dos
        $newWeight = $backpack->weight + $item->getWeight();
        $newVolume = $backpack->volume + $item->getVolume();
        
        $itemData = $item->getItem();
        $itemData['backpack_id'] = $backpack->id;

        // Si le poids ou bien le volume dépasse la capacité du sac on ne l'ajoute pas
        if ($newWeight > $backpack->max_weight || $newVolume > $backpack->max_volume) {
            return response()->json([
                'error' => 'Impossible d’ajouter : sac trop chargé',
                'current_weight' => $backpack->weight,
                'current_volume' => $backpack->volume,
                'max_weight' => $backpack->max_weight,
                'max_volume' => $backpack->max_volume
            ], 400);
        }
        // Sinon on met à jour le poids et le volume du sac on l'ajoute
        else{
            // Mise à jour du poids et du volume du sac à dos
            $backpack->update([
                'weight' => $newWeight,
                'volume' => $newVolume,
            ]);
            $backpack->items()->create($itemData);
            
            return response()->json([
                'message' => 'Objet ajouté',
                'item' => $data
            ]);
        }
    }

    // Supprimer un item du sac à dos
    public function delete(Request $request, $id)
    {   
        // Trouver l'item et le sac à dos associé
        $item = Item::findOrFail($id);

        // Récupérer l'id du sac à dos
        $backpack = Sac::findOrFail($item->backpack_id);

        // Mettre à jour le poids et le volume du sac à dos
        $newWeight = $backpack->weight - $item->weight;
        $newVolume = $backpack->volume - $item->volume;

        $backpack->update([
            'weight' => $newWeight,
            'volume' => $newVolume,
        ]);

        // Supprimer l'item de la base de données
        $item->delete();

        return response()->json(['message' => 'Objet supprimé']);
    }

}
