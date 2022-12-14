@extends('frontend.layout')

@section('styles')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
@endsection

@section('footerScripts')
    <script src="{{ asset('js/filter.js') }}"></script>
@endsection

@section('content')
    <div class="flex">
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
                    <img src="/images/{{ $episode->imageFilename }}.jpg" class="thumbnail"
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
                        @if ($episode->redditId)
                            <div class="button right reddit"><a
                                    href="https://www.reddit.com/rpan/r/RedditSets/{{ $episode->redditId }}"><i
                                        class="fa-brands fa-reddit"></i> Reddit</a></div>
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
