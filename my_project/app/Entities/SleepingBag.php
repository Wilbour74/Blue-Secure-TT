<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class SleepingBag extends AbstractItem
{
    public function __construct(string $name, float $weight, float $volume)
    {
        parent::__construct($name, $weight, $volume);
    }
    // J'ai choisi de ne pas mettre de facteur d'usure pour le sac de couchage
    public function useItem(float $consumption = 0): string
    {
        return "Tu déplies ton sac de couchage.";
    }

    public function getDescription(): string
    {
        return "Sac de couchage confortable pour passer la nuit.";
    }
}
