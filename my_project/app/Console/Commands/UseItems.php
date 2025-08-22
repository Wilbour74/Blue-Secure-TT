<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Entities\Compass as Boussole;
use App\Entities\Knife as Couteau;
use App\Entities\WaterBottle as Gourde;
use App\Entities\Kit as Trousse;
use App\Entities\Lighter as Briquet;
use App\Entities\Map as Carte;
use App\Entities\Rations;
use App\Entities\SleepingBag as SacDeCouchage;
use App\Entities\Tinder as Amadou;
use App\Entities\TorchKit as MateriauxTorche;
use App\Entities\Backpack;
use App\Services\BackpackService;

class UseItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:use-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ce script a pour but d\'afficher les différents messages en fonction de l\'utilisation de chaque Objet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $backpack = new Backpack(100, 100);
        $service = new BackpackService($backpack);

        // Initialisation des objetsù
        $boussole = new Boussole("Boussole", 0.2, 0.1);
        $couteau = new Couteau("Couteau de chasse", 0.5, 15, 100);
        $gourde = new Gourde("Gourde", 0.5, 1.0, 5);
        $trousse = new Trousse("Trousse de secours", 1.0, 2.0, 10);
        $briquet = new Briquet("Briquet", 0.1, 0.1, 100);
        $carte = new Carte("Carte", 0.1, 0.1);
        $rations = new Rations("Rations", 1.0, 1.0, 5);
        $sacDeCouchage = new SacDeCouchage("Sac de couchage", 2.0, 3);
        $amadou = new Amadou("Amadou", 0.1, 0.1, 6);
        $materiauxTorche = new MateriauxTorche("Matériaux", 0.5, 1.0, 5);
        
        // Ajouts des objets dans le sac à dos
        $this->info($service->addItemsToBackpack(
            $boussole,
            $couteau,
            $gourde,
            $trousse,
            $briquet,
            $carte,
            $rations,
            $sacDeCouchage,
            $amadou,
            $materiauxTorche
        ));

        $this->line($service->getBackpackStats());
        $this->line($service->useItemFromBackpack($boussole->getName()));
        $this->line($service->useItemFromBackpack($couteau->getName(), 10));
        $this->line($service->useItemFromBackpack($gourde->getName(), 1));
        $this->line($service->useItemFromBackpack($trousse->getName(), 2));
        $this->line($service->useItemFromBackpack($briquet->getName(), 50));
        $this->line($service->useItemFromBackpack($carte->getName()));
        $this->line($service->useItemFromBackpack($rations->getName(),4));
        $this->line($service->useItemFromBackpack($sacDeCouchage->getName()));
        $this->line($service->useItemFromBackpack($amadou->getName(), 2));
        //Ici on donne volontairement plus qu'il y'en a pour verifier si le message d'erreur s'affiche
        $this->line($service->useItemFromBackpack($materiauxTorche->getName(), 6));
    }
}
