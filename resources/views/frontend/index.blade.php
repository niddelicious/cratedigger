@extends('frontend.layout')

@section('styles')
    <link href="{{ mix('css/style.css') }}" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/blazy/latest/blazy.min.js"></script>
    <script type="text/javascript">
        var bLazy = new Blazy({ 
            selector: 'img',
            container: '#main-content'
        });
    </script>
@endsection

@section('footerScripts')
    <script src="{{ mix('js/filter.js') }}"></script>
@endsection

@section('content')
    <div class="flex" id="main-content">
        @if ($featured)
            @include('frontend.featured')
        @endif

        <div class="expanded">
            <h2>Archive</h2>
            <button class="filterButton activeFilter" data-filter="all">All</button>
            @foreach ($styles as $style)
                <button class="filterButton" data-filter="{{ strtolower($style) }}">{{ ucfirst($style) }}</button>
            @endforeach
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @foreach ($episodes as $episode)
            <div class="episode flex" data-style="{{ strtolower($episode->style) }}">
                <div class="image">
                    <img src="/coverart/{{ $episode->imageFilename }}.jpg" class="thumbnail b-lazy" data-src="/coverart/{{ $episode->imageFilename }}.jpg"
                        alt="Cover art for {{ $episode->title }}" />
                </div>
                <div class="episodeData">
                    <div class="episodeInfo">Title:</div>
                    <div class="title highlight">{{ $episode->title }}</div>
                    <div class="episodeInfo">Style / Genre:</div>
                    <div class="style genre">{{ $episode->style }} / {{ $episode->genre }}</div>
                    @if ($episode->twitchSafe == true)
                        <div><span class="tag twitch">Twitch-safe</span></div>
                    @endif
                </div>
                <div class="buttons">
                    @if ($episode->twitchId || $episode->youtubeId || $episode->redditId)
                        <div class="episodeInfo">View:</div>
                        @if ($episode->twitchId && !$episode->twitchTooOld)
                            <div class="button right twitch"><a href="https://twitch.tv/videos/{{ $episode->twitchId }}"><i
                                        class="fa-brands fa-twitch"></i> Twitch</a></div>
                        @endif
                        @if ($episode->youtubeId)
                            <div class="button right youtube"><a href="https://youtu.be/{{ $episode->youtubeId }}"><i
                                        class="fa-brands fa-youtube"></i> YouTube</a></div>
                        @endif
                    @endif
                    @if ($episode->mp3Filename)
                        <div class="episodeInfo">Download:</div>
                        <div class="button right mp3"><a
                                href="{{ asset('mp3/' . rawurlencode($episode->mp3Filename) . '.mp3') }}" download><i
                                    class="fa-solid fa-podcast"></i> MP3</a></div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
