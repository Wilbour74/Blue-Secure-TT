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


class ItemController extends Controller
{
    public function index($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    public function useItem(Request $request, $id)
    {
        $data = Item::findOrFail($id);

        // Interchanger les utilisations en fonction du type d'objet
        switch ($data->type) {
            case 'Gourde':
                $item = new Gourde($data->name, $data->weight, $data->volume, $data->quantity);
                $using = $item->useItem($request->input('amount'));
                $data->quantity = $item->getQuantity();
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

            case 'SacDeCouchage':
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
        // Mettre à jour la base de données
        $data->save();

        return response()->json([
            'message' => 'Item used successfully',
            'result' => $using,
            'item' => $item->getItem(),
            'quantity' => $data->quantity ?? null,
            'wear' => $data->wear ?? null
        ]);
    }

}
