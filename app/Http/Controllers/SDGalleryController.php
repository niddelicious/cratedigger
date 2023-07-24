<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SDGalleryController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directory = "public/sd-thumbs";

        $thumbnails = Storage::files($directory);
        $thumbnails = array_map(function($thumbnail) {
            return str_replace("public/", "storage/", $thumbnail);
        }, $thumbnails);

        $random_image = $thumbnails[array_rand($thumbnails)];

        $image = str_replace(".jpg", ".png", str_replace("sd-thumbs/", "sd-img/", $thumbnails[array_rand($thumbnails)]));

        return view('gallery.gallery', compact(['thumbnails', 'image', 'random_image']));
    }
}
