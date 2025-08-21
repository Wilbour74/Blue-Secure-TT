<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Knife extends AbstractItem
{
    private int $wear;

    public function __construct(string $name, float $weight, float $volume, int $wear)
    {
        parent::__construct($name, $weight, $volume);
        $this->wear = 100;
    }

    public function getWear(): int
    {
        return $this->wear;
    }

    // Dans l'idée faire une sorte de barre de vie pour l'objet qui s'usera au fur 
    public function useItem(float $consumption = 10): string
    {
        // Lorsque son pourcentage est à 0 impossible de l'utiliser
        if($this->wear <= 0){
            return "Ton couteau est inutilisable";
        } 

        $wear = $this->wear - $consumption;
        if($this->wear < 0) $this->wear = 0;

        return "Tu as utilisé ton couteau, il lui reste {$wear}%";
    }

    public function getDescription(): string
    {
        return "Voici un couteau très ordinaire, il lui reste {$this->wear}%";
    }
}