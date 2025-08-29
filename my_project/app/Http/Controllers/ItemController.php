<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
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
use App\Models\Backpack as Sac;
use App\Http\Requests\AddItemRequest;


class ItemController extends Controller
{
    public function index($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    public function add(AddItemRequest $request, $id)
    {
        $data = $request->validated();

        // Vérification des champs obligatoires selon le type
        switch ($data['type']) {
            case 'Gourde':
                if (!isset($data['quantity_cl'])) {
                    return response()->json([
                        'message' => "Le champ 'CL' est requis pour une gourde."
                    ]);
                }
                $item = new Gourde($data['name'], $data['weight'], $data['volume'], $data['quantity_cl']);
                break;

            case 'Couteau':
                if (!isset($data['wear'])) {
                    return response()->json([
                        'message' => "Le champ 'Usure' est requis pour un couteau."
                    ]);
                }
                $item = new Couteau($data['name'], $data['weight'], $data['volume'], $data['wear']);
                break;

            case 'Boussole':
                $item = new Boussole($data['name'], $data['weight'], $data['volume']);
                break;

            case 'Trousse':
                if (!isset($data['quantity'])) {
                    return response()->json([
                        'message' => "Le champ 'Qty' est requis pour une trousse."
                    ]);
                }
                $item = new Trousse($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;

            case 'Briquet':
                if (!isset($data['wear'])) {
                    return response()->json([
                        'message' => "Le champ 'Usure' est requis pour un briquet."
                    ]);
                }
                $item = new Briquet($data['name'], $data['weight'], $data['volume'], $data['wear']);
                break;

            case 'Carte':
                $item = new Carte($data['name'], $data['weight'], $data['volume']);
                break;

            case 'Rations':
                if (!isset($data['quantity'])) {
                    return response()->json([
                        'message' => "Le champ 'Qty' est requis pour des rations."
                    ]);
                }
                $item = new Rations($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;

            case 'SacDeCouchage':
                $item = new SacDeCouchage($data['name'], $data['weight'], $data['volume']);
                break;

            case 'Amadou':
                $item = new Amadou($data['name'], $data['weight'], $data['volume']);
                break;

            case 'MateriauxTorche':
                if (!isset($data['quantity'])) {
                    return response()->json([
                        'message' => "Le champ 'quantity' est requis pour les matériaux de torche."
                    ]);
                }
                $item = new MateriauxTorche($data['name'], $data['weight'], $data['volume'], $data['quantity']);
                break;

            default:
                return response()->json(['error' => 'Type inconnu'], 400);
        }

        // Vérifier que le sac existe
        $backpack = Sac::find($id);
        if (!$backpack) {
            return response()->json(['error' => 'Sac à dos non trouvé'], 404);
        }

        // Calcul du poids et volume
        $newWeight = $backpack->weight + $item->getWeight();
        $newVolume = $backpack->volume + $item->getVolume();

        $itemData = $item->getItem();
        $itemData['backpack_id'] = $backpack->id;

        // Vérif capacité
        if ($newWeight > $backpack->max_weight || $newVolume > $backpack->max_volume) {
            return response()->json([
                'error' => 'Impossible d’ajouter : sac trop chargé',
                'current_weight' => $backpack->weight,
                'current_volume' => $backpack->volume,
                'max_weight' => $backpack->max_weight,
                'max_volume' => $backpack->max_volume
            ], 400);
        }

        // Mise à jour du sac
        $backpack->update([
            'weight' => $newWeight,
            'volume' => $newVolume,
        ]);

        // Ajout de l’item
        $newItem = $backpack->items()->create($itemData);

        if (!$newItem) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible d’ajouter l’objet au sac. Valeur incorrecte'
            ]);
        }

        return response()->json([
            'message' => 'Objet ajouté',
            'item' => $data
        ]);
    }


    public function useItem(Request $request, $id)
    {
        $data = Item::findOrFail($id);
        // Interchanger les utilisations en fonction du type d'objet
        switch ($data->type) {
            case 'Gourde':
                $item = new Gourde($data->name, $data->weight, $data->volume, $data->quantity_cl);
                $using = $item->useItem($request->input('amount'));
                $data->quantity_cl = $item->getQuantity();
                break;

            case 'Couteau':
                $item = new Couteau($data->name, $data->weight, $data->volume, $data->wear);
                $using = $item->useItem($request->input('amount'));
                $data->wear = $item->getWear();
                break;

            case 'Boussole':
                $item = new Boussole($data->name, $data->weight, $data->volume);
                $using = $item->useItem();
                break;

            case 'Trousse':
                $item = new Trousse($data->name, $data->weight, $data->volume, $data->quantity);
                $using = $item->useItem($request->input('amount'));
                $data->quantity = $item->getQuantity(); 
                break;

            case 'Briquet':
                $item = new Briquet($data->name, $data->weight, $data->volume, $data->wear);
                $using = $item->useItem($request->input('amount'));
                $data->wear = $item->getWear();
                break;

            case 'Carte':
                $item = new Carte($data->name, $data->weight, $data->volume);
                $using = $item->useItem();
                break;

            case 'Rations':
                $item = new Rations($data->name, $data->weight, $data->volume, $data->quantity);
                $using = $item->useItem($request->input('amount'));
                $data->quantity = $item->getQuantity();
                break;

            case 'Sac de couchage':
                $item = new SacDeCouchage($data->name, $data->weight, $data->volume);
                $using = $item->useItem();
                break;

            case 'Amadou':
                $item = new Amadou($data->name, $data->weight, $data->volume, $data->quantity);
                $using = $item->useItem($request->input('amount'));
                $data->quantity = $item->getQuantity();
                break;

            case 'MateriauxTorche':
                $item = new MateriauxTorche($data->name, $data->weight, $data->volume, $data->quantity);
                $using = $item->useItem($request->input('amount'));
                $data->quantity = $item->getQuantity();
                break;

            default:
                return response()->json(['error' => 'Type inconnu'], 400);
        }
        
        // Si l'item est épuisé ou s'il n'en reste plus impossible de l'utiliser
        if (($data->quantity !== null && $data->quantity < 0) ||
            ($data->wear !== null && $data->wear < 0) ||
            ($data->quantity_cl !== null && $data->quantity_cl < 0)) {

            return response()->json([
                'message' => 'Erreur : l\'item est épuisé ou cassé',
                'result' => $using,
                'item' => $item->getItem(),
                'quantity' => $data->quantity ?? null,
                'wear' => $data->wear ?? null,
                'quantity_cl' => $data->quantity_cl ?? null
            ]);
        }

        $backpack = Sac::find($data->backpack_id);

        // Si le poids ou le volume dépasse les limites du sac à dos
        if (($data->weight > $backpack->max_weight) ||
            ($data->volume > $backpack->max_volume)) {

            return response()->json([
                'message' => 'Erreur : l\'item dépasse les limites du sac à dos',
                'result' => $using,
                'item' => $item->getItem(),
                'weight' => $data->weight ?? null,
                'volume' => $data->volume ?? null
            ]);
        }

        // Sinon le mettre à jour en base de données
         else{
            $data->save();
            return response()->json([
                'itemId' => $data->id,
                'message' => 'Item utilisé avec succès',
                'result' => $using,
                'item' => $data,
                'quantity' => $data->quantity ?? null,
                'wear' => $data->wear ?? null
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
        if($item->delete()){
            return response()->json(['message' => 'Objet supprimé']);
        } else{
            return response()->json(['message' => 'Erreur lors de la suppression de l\'objet'], 500);
        }

        
    }
}
