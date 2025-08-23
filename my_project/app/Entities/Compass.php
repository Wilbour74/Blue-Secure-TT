<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Compass extends AbstractItem
{
    private int $quantity;

    public function __construct(string $name, float $weight, float $volume){
        parent::__construct($name, $weight, $volume);
    }

    // Dans la logique ou la boussole ne s'use pas, pas de consommation
    public function useItem(float $consommation = 0): string
    {
        // Retourner une direction aléatoire
        $directions = ["Nord", "Sud", "Est", "Ouest"];
        $direction = $directions[array_rand($directions)];
        return "Tu consultes ta {$this->getName()}, elle indique le {$direction}.";
    }

    public function getDescription(): string
    {
        return "Ceci est une boussole ordinaire";
    }

    public function getItem() : array
    {
        return [
            "type" => "Boussole",
            "name" => strval($this->getName()),
            "weight" => $this->getWeight(),
            "volume" => $this->getVolume(),
            "description" => strval($this->getDescription()),
        ];
    }
}