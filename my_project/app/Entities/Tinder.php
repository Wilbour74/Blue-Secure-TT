<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Tinder extends AbstractItem
{
    private int $quantity;

    public function __construct(string $name, float $weight, float $volume, int $quantity)
    {
        parent::__construct($name, $weight, $volume);
        $this->quantity = $quantity;
    }

    public function useItem(float $consumption = 0): string
    {
        if ($this->quantity > 0) {
            $this->quantity--;
            return "Tu utilises un morceau d’amadou. Il t’en reste {$this->quantity}.";
        }
        return "Tu n’as plus d’amadou !";
    }

    public function getDescription(): string
    {
        return "Petits morceaux d’amadou pour allumer un feu.";
    }
}
