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

        if ($image_id !== null) {
            $image = str_replace(".jpg", ".png", str_replace("sd-thumbs/", "sd-img/", "storage/sd-thumbs/{$image_id}.jpg"));
            $lossy = str_replace("sd-thumbs/", "sd-lossy/", "storage/sd-thumbs/{$image_id}.jpg");
        } else {
            $image_id = $thumbnails[array_rand($thumbnails)];
            $image = str_replace(".jpg", ".png", str_replace("sd-thumbs/", "sd-img/", $image_id));
            $lossy = str_replace("sd-thumbs/", "sd-lossy/", $image_id);
        }

        return view('gallery.gallery', compact('thumbnails', 'image', 'lossy', 'image_id'));
    }
}
