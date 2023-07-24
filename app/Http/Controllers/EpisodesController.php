<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{

    public function list()
    {
        $episodes = Episode::orderBy('date', 'DESC')->get();

        return view('frontend.index', compact('episodes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $episodes = Episode::orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();

        return view('backend.episodes.index', compact('episodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.episodes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'genre' => 'required',
        ]);
    
        Episode::create($request->all());
     
        return redirect()->route('episodes.index')
                        ->with('success','Episode created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function show(Episode $episode)
    {
        return view('backend.episodes.show',compact('episode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function edit(Episode $episode)
    {
        return view('backend.episodes.edit',compact('episode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Episode $episode)
    {
        $request->validate([
            'title' => 'required',
            'genre' => 'required',
        ]);

        $episode->twitchSafe = $request->input('twitchSafe') ? true : false;
    
        $episode->update($request->all());
    
        return redirect()->route('episodes.index')
                        ->with('success','Episode updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Episode  $episode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Episode $episode)
    {
        $episode->delete();
    
        return redirect()->route('episodes.index')
                        ->with('success','Episode deleted successfully');
    }
}
