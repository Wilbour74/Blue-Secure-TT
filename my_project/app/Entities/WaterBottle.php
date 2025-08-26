<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class WaterBottle extends AbstractItem
{
    private float $quantity_cl;

    public function __construct(string $name, float $weight, float $volume, float $quantity_cl){
        parent::__construct($name, $weight, $volume);
        $this->quantity_cl = $quantity_cl;
    }

    public function getQuantity(): float
    {
        return $this->quantity_cl;
    }

    // Action de boire une certaine quantité d'eau
    public function useItem(float $consumption): string
    {
        if($this->quantity_cl <= 0) {
            return "Ta gourde est vide.";
        }

        if($consumption > $this->quantity_cl) {
            return "Tu ne peux pas boire plus que {$this->quantity_cl} cL.";
        }

        $this->quantity_cl -= $consumption;

        return "Tu as bu {$consumption} cL. Il reste {$this->quantity_cl} cL dans la gourde.";
    }

    public function getDescription(): string
    {
        return "C'est une gourde tout a fait ordinaire.";
    }

    public function getItem() : array
    {
        return [
            "type" => "Gourde",
            "name" => strval($this->getName()),
            "weight" => $this->getWeight(),
            "volume" => $this->getVolume(),
            "description" => strval($this->getDescription()),
            "quantity_cl" => $this->getQuantity()
        ];
    }
}