<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixCommandImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-command-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $items = CommandeItem::whereNotNull('article_image')->get();
    
    foreach ($items as $item) {
        $currentPath = $item->article_image;
        
        // Correction des chemins
        if (str_starts_with($currentPath, 'commandes/')) {
            $newPath = 'storage/'.$currentPath;
        } elseif (!str_starts_with($currentPath, 'storage/')) {
            $newPath = 'storage/'.$currentPath;
        } else {
            $newPath = $currentPath;
        }
        
        // Vérification de l'existence du fichier
        $relativePath = str_replace('storage/', '', $newPath);
        if (!Storage::disk('public')->exists($relativePath)) {
            $newPath = null;
        }
        
        if ($newPath !== $currentPath) {
            $item->article_image = $newPath;
            $item->save();
        }
    }
    
    $this->info('Chemins des images de commande corrigés avec succès !');
}
}
