<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessImage;

class PagesController extends Controller
{
    public function resize()
    {
        $time =microtime(true);
        $directory=storage_path('art');//dossier contenant mes images
        $images =array_merge( //selectionne que les fichiers ayant l'extension jpp,png
          glob("$directory/*.jpg"),
            glob("$directory/*.png")
        );
        foreach($images as $image)
        { //utilisons la methode dispatch à fin qu'il envoi nos image en file d'attente
            ProcessImage::dispatch($image,'large',1000);
            ProcessImage::dispatch($image,'medium',500,500);
            ProcessImage::dispatch($image,'small',250,250);
        }
        return 'processus génére en ' . round(microtime(true)-$time, 2). 's';
    }
}
