<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Backpack
{
    private float $maxVolume;
    private float $maxWeight;
    private float $currentVolume = 0.0;
    private float $currentWeight = 0.0;
    private array $items = [];

    public function __construct(float $maxWeight = 30.0, float $maxVolume = 30.0)
    {
        $this->maxWeight = $maxWeight;
        $this->maxVolume = $maxVolume;
    }

    // Logique d'ajout d'objets
    public function addItems(AbstractItem ...$items): array
    {
        $added = [];
        $failed = [];

        foreach ($items as $item) {
            // Si l'ajout dépasse les limites, on refuse l'objet
            if ($this->currentVolume + $item->getVolume() > $this->maxVolume || 
                $this->currentWeight + $item->getWeight() > $this->maxWeight) {
                $failed[] = $item->getName();
            }
            // Sinon, on l'ajoute dans le tableau
            else {
                $this->items[] = $item;
                $this->currentVolume += $item->getVolume();
                $this->currentWeight += $item->getWeight();
                $added[] = $item->getName();
            }
        }

        return ['added' => $added, 'failed' => $failed];
    }

    public function getMaxWeight(): float
    {
        return $this->maxWeight;
    }

    public function getMaxVolume(): float
    {
        return $this->maxVolume;
    }

    public function getWeight(): float
    {
        return $this->currentWeight;
    }

    public function getVolume(): float
    {
        return $this->currentVolume;
    }

    public function getCount(): int
    {
        return count($this->items);
    }

    public function listItemsJson(): array
    {
        return array_map(function($item) {
            return [
                'name' => $item->getName(),
                'weight' => $item->getWeight(),
                'volume' => $item->getVolume(),
                'info' => $item->getDescription(),
                'quantity' => method_exists($item, 'getQuantity')
                ? $item->getQuantity()
                : (method_exists($item, 'getWear') ? $item->getWear() : null),
            ];
        }, $this->items);
    }

    public function listItems(): array
    {
        return $this->items;
    }
}
