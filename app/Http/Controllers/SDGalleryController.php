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
    public function index($image_id = null) {
        $directory = "storage/sd-img";

        $images = collect(File::allFiles($directory))
            ->filter(function ($file) {
                return in_array($file->getExtension(), ['png']);
            })
            ->sortByDesc(function ($file) {
                return $file->getCTime();
            })
            ->groupBy(function ($file) {
                return date('Y-m-d', $file->getCTime());
            })
            ->map(function ($group) {
                return $group->map(function ($file) {
                    return $file->getBaseName();
                });
            });

        $thumbnails = [];
        foreach ($images as $date => $group) {
            $groupThumbnails = [];
            foreach ($group as $image) {
                $groupThumbnails[] = "storage/sd-thumbs/" . pathinfo($image, PATHINFO_FILENAME) . ".jpg";
            }
            $thumbnails[$date] = $groupThumbnails;
        }

        $image_id = $image_id ?: str_replace(".png", "", $images->flatten(1)->random());

        $image = "storage/sd-img/{$image_id}.png";
        $lossy = "storage/sd-lossy/{$image_id}.jpg";

        return view('gallery.gallery', compact('thumbnails', 'image', 'lossy', 'image_id', 'images'));
    }
}
