<?php

namespace App\Services;

use App\Models\Backpack;
use App\Abstracts\AbstractItem;

class BackpackService
{
    private Backpack $backpack;

    public function __construct(Backpack $backpack)
    {
        $this->backpack = $backpack;
    }

    // Plutot que de faire plusieurs addItem, possibilité d'en ajouter plusieurs avec la même fonction
    public function addItemsToBackpack(AbstractItem ...$items): string
    {
        if ($this->backpack->addItems(...$items)) {
            $names = array_map(fn($i) => $i->getName(), $items);
            return "Objets ajoutés : " . implode(", ", $names) . "\n";
        }
        return "Impossible d'ajouter certains objets (sac plein).\n";
    }

    public function listBackpackContents(): string
    {
        $output = "📦 Contenu du sac :\n";
        foreach ($this->backpack->listItems() as $item) {
            $output .= "- " . $item->getName() 
                . " (poids: " . $item->getWeight() 
                . " kg, volume: " . $item->getVolume() . " L)\n";
        }
        return $output;
    }

    public function getBackpackStats(): string
    {
        return "Sac → Nombre d'objets: " . $this->backpack->getCount()
            . " | Poids total: " . $this->backpack->getWeight() . " kg"
            . " | Volume total: " . $this->backpack->getVolume() . " L\n";
    }
}
