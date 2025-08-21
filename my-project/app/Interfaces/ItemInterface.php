<?php

namespace App\Interfaces;

// Definition des méthodes à utiliser obligatoirement
interface ItemInterface {
    public function getName(): string;
    public function getDescription(): string;
    public function getWeight(): float;
    public function getVolume(): float;
}