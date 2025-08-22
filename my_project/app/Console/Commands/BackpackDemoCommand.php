<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\Backpack;
use App\Services\BackpackService;
use App\Entities\WaterBottle as Gourde;
use App\Entities\Knife as Couteau;
use App\Entities\Compass as Boussole;

class BackpackDemoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backpack-demo-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Le but de cette commande est de tester le fait d\'ajouter des objets dans un sac à dos plein';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Backpack(poidsMax,volumeMax)
        $backpack = new Backpack(15.0, 15.0); // Backpack(poidsMax,volumeMax)
        $service = new BackpackService($backpack);

        // Création des objets
        $gourde = new Gourde("Gourde", 0.5, 1.0, 5.0);
        $couteau = new Couteau("Couteau de chasse", 0.5, 15, 100);
        $boussole = new Boussole("Boussole", 0.2, 0.1);

        // Ajout de multiples items dans le sac à dos
        $this->info($service->addItemsToBackpack($gourde, $couteau, $boussole));

        // Affichage des stats
        $this->line($service->getBackpackStats());

        // Affichage du contenu
        $this->line($service->listBackpackContents());

        return self::SUCCESS;
    }
}
