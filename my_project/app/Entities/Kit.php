<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Kit extends AbstractItem
{
    private int $quantity;

    public function __construct(string $name, float $weight, float $volume, int $quantity)
    {
        parent::__construct($name, $weight, $volume);
        $this->quantity = $quantity;
    }

    // Dans l'idée ou le kit aurait plusieurs medicaments a utiliser
    public function useItem(float $consommation = 0): string
    {
        if ($this->quantity > 0) {
            $this->quantity--;
            return "Tu utilises la {$this->getName()}. Il te reste {$this->quantity} utilisations.";
        }
        return "Ta trousse {$this->getName()} est vide";
    }

    public function getDescription(): string
    {
        return "Trousse de secours pour soigner blessures et petites urgences.";
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
