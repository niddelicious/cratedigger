<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SDGalleryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($image_id = null)
    {
        $directory = "storage/sd-img";

        $images = collect(File::allFiles($directory))
        ->filter(function ($file) {
            return in_array($file->getExtension(), ['png']);
        })
        ->sortBy(function ($file) {
            return $file->getCTime();
        })
        ->map(function ($file) {
            return $file->getBaseName();
        });

        foreach($images->all() as $image){
            $thumbnails[] = "storage/sd-thumbs/" . str_replace(".png", ".jpg", $image);
        }

        $image_id = $image_id ?: str_replace(".png", "", $images->random());

        $image = "storage/sd-img/{$image_id}.png";
        $lossy = "storage/sd-lossy/{$image_id}.jpg";

        return view('gallery.gallery', compact('thumbnails', 'image', 'lossy', 'image_id'));
    }
}
