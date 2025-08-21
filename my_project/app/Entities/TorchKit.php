<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class TorchKit extends AbstractItem
{
    private int $quantity;

    public function __construct(string $name, float $weight, float $volume, int $quantity)
    {
        parent::__construct($name, $weight);
        $this->quantity = $quantity;
    }

    public function useItem(int $consumption = 1): string
    {
        if ($this->quantity >= $consumption) {
            $this->quantity -= $consumption;
            return "Tu utilises {$consumption} matériau(s) pour fabriquer une torche. Il t’en reste {$this->quantity}.";
        }
        return "Pas assez de matériaux pour fabriquer une torche !";
    }

    public function getDescription(): string
    {
        return "Matériaux nécessaires pour fabriquer des torches (amadou, bâtons, etc.)";
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
