<?php

namespace App\Abstracts;

use App\Interfaces\ItemInterface;

// Classe abstraite pour les items
abstract class AbstractItem implements ItemInterface{
    protected string $name;
    protected float $weight;
    protected float $volume;

    public function __construct(string $name, float $weight, float $volume)
    {
        $this->name = $name;
        $this->weight = $weight;
        $this->volume = $volume;
    }

    public function getName() : String
    {
        return $this->name;
    }

    public function getWeight() : Float
    {
        return $this->weight;
    }

    public function getVolume() : Float{
        return $this->volume;
    }

    // Fonctions a redefinir dans les classes conctrètes
    abstract public function getDescription(): String;

    abstract public function useItem(float $quantity): String;

    abstract public function getItem(): array;
}
