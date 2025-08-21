<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Rations extends AbstractItem
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

    // Dans l'idée, les rations de survies serait dans un kit et on pourrait en prendre au fur et à mesure
    public function useItem(float $consumption): string
    {
        if ($this->quantity <= 0) {
            return "Tu n'as plus de rations.";
        }

        $this->quantity -= $consumption;
        if ($this->quantity < 0) $this->quantity = 0;

        return "Tu as consommé {$consumption} ration de survie . Il en reste t'en reste {$this->quantity}.";
    }

    public function getDescription(): string
    {
        return "C'est important d'avoir de quoi manger voici des rations de nouriture, il en reste actuellement {$this->quantity}";
    }

}