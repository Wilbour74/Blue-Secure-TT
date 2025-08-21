<?php

namespace App\Entities;

use App\Abstracts\AbstractItem;

class Lighter extends AbstractItem
{
    private int $wear;

    public function __construct(string $name, float $weight, float $volume, int $wear)
    {
        parent::__construct($name, $weight, $volume);
        $this->wear = $wear;
    }

    public function getWear(): int
    {
        return $this->wear;
    }

    // Utilisation du gaz du briquet
    public function useItem(float $consumption = 0): string
    {
        if ($this->wear > 0) {
            $this->wear--;
            return "Tu allumes ton {$this->getName()}. Charge restante : {$this->wear} %.";
        }
        return "Ton {$this->getName()} est vide !";
    }

    public function getDescription(): string
    {
        return "Ceci est un briquet tempête. Il lui reste {$this->wear} % d'usage";
    }
}
