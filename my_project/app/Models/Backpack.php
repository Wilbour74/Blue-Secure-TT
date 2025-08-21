<?php

namespace App\Models;

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
            if ($this->currentVolume + $item->getVolume() > $this->maxVolume || 
                $this->currentWeight + $item->getWeight() > $this->maxWeight) {
                $failed[] = $item->getName();
            } else {
                $this->items[] = $item;
                $this->currentVolume += $item->getVolume();
                $this->currentWeight += $item->getWeight();
                $added[] = $item->getName();
            }
        }

        return ['added' => $added, 'failed' => $failed];
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

    public function listItems(): array
    {
        return $this->items;
    }
}
