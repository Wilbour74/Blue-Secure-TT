<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class WaterBottle extends AbstractItem
{
    private int $quantity;

    public function __construct(string $name, float $weight, float $volume, int $quantity){
        parent::__construct($name, $weight, $volume);
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    // Action de boire une certaine quantité d'eau
    public function useItem(float $consumption): string
    {
        if ($this->quantity <= 0) {
            return "Ta gourde est vide.";
        }

        $this->quantity -= $consumption;
        if ($this->quantity < 0) $this->quantity = 0;

        return "Tu as bu {$consumption} cL. Il reste {$this->quantity} cL dans la gourde.";
    }

    public function getDescription(): string
    {
        return "C'est une gourde tout a fait ordinaire, il reste actuellement {$this->quantity} cL";
    }
}