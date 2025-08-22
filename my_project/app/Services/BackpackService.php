<?php

namespace App\Services;

use App\Entities\Backpack;
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
        $result = $this->backpack->addItems(...$items);

        $message = '';
        if (!empty($result['added'])) {
            $message .= "Objets ajoutés : " . implode(", ", $result['added']) . "\n";
        }
        if (!empty($result['failed'])) {
            $message .= "Objets non ajoutés (sac plein) : " . implode(", ", $result['failed']) . "\n";
        }

        return $message;
    }

    public function useItemFromBackpack(string $itemName, float $consumption = 1): string
    {
        $items = $this->backpack->listItems();

        foreach ($items as $item) {
            if ($item->getName() === $itemName) {
                return $item->useItem($consumption);
            }
        }

        return "Objet non trouvé dans le sac : " . $itemName . "\n";
    }
    public function listBackpackContents(): string
    {
        $output = "Contenu du sac :\n";
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
