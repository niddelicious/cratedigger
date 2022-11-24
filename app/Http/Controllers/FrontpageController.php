<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Message;
use Illuminate\Http\Request;

class FrontpageController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::where('active', 1)->orderBy('created_at', 'DESC')->first();
        $featured = Episode::where('featured', 1)->orderBy('date', 'DESC')->first();
        $episodes = Episode::orderBy('date', 'DESC')->get();
        $styles = Episode::groupBy('style')->orderBy('style', 'ASC')->pluck('style');

        return view('frontend.index', compact(['messages', 'featured', 'episodes', 'styles']));
    }
}
