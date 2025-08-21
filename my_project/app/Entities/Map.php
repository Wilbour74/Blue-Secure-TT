<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Map extends AbstractItem
{
    public function __construct(string $name, float $weight, float $volume)
    {
        parent::__construct($name, $weight, $volume);
    }


    // Pas de facteur d'usure pour la carte donc consultation aléatoire d'un élement sur la carte
    public function useItem(float $consumption = 0): string
    {
        $places = ["Lac", "Mont", "Village", "Desert"];
        $place = $places[array_rand($places)];
        return "Tu consultes ta {$this->getName()}, tu vois le {$place}.";
    }

    public function getDescription(): string
    {
        return "Ceci est une carte de la région.";
    }
}
