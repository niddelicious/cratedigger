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
    public function index($image_id = null)
    {
        $directory = "public/sd-thumbs";

        $thumbnails = Storage::files($directory);
        $thumbnails = array_map(fn($thumbnail) => str_replace("public/", "storage/", $thumbnail), $thumbnails);

        $image_id = $image_id ?: str_replace(".jpg", "", basename($thumbnails[array_rand($thumbnails)]));

        $image = "storage/sd-img/{$image_id}.png";
        $lossy = "storage/sd-lossy/{$image_id}.jpg";

        return view('gallery.gallery', compact('thumbnails', 'image', 'lossy', 'image_id'));
    }
}
