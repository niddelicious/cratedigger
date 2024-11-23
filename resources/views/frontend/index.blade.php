@extends('frontend.layout')

@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/style.css') }}" rel="stylesheet" />
    <link href="{{ mix('css/crateButton.css') }}" rel="stylesheet" />
@endsection

@section('footerScripts')
    <script src="{{ mix('js/filter.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wall = document.getElementById('episodes-wall');
            const thumbnails = document.querySelectorAll('.thumbnail-wrapper');
            let activeIndex = null;

            thumbnails.forEach((thumbnail) => {
                thumbnail.addEventListener('click', () => {
                    const index = thumbnail.dataset.index;

                    if (activeIndex === index) {
                        // Collapse the active thumbnail if clicked again
                        collapseThumbnail(thumbnail);
                        activeIndex = null;
                    } else {
                        // Collapse the previous active thumbnail
                        if (activeIndex !== null) {
                            const activeThumbnail = document.querySelector(
                                `.thumbnail-wrapper[data-index="${activeIndex}"]`
                            );
                            collapseThumbnail(activeThumbnail);
                        }

                        // Expand the clicked thumbnail
                        expandThumbnail(thumbnail);
                        activeIndex = index;
                    }
                });
            });

            function expandThumbnail(thumbnail) {
                const expandedContent = thumbnail.querySelector('.expanded-content');
                expandedContent.classList.remove('hidden');
                const expandedContentTB = thumbnail.querySelector('.expanded-content-tb');
                expandedContentTB.classList.remove('hidden');
                const expandedContentBB = thumbnail.querySelector('.expanded-content-bb');
                expandedContentBB.classList.remove('hidden');
                thumbnail.classList.add('w-full'); // Make the box expand to the row
            }

            function collapseThumbnail(thumbnail) {
                const expandedContent = thumbnail.querySelector('.expanded-content');
                expandedContent.classList.add('hidden');
                const expandedContentTB = thumbnail.querySelector('.expanded-content-tb');
                expandedContentTB.classList.add('hidden');
                const expandedContentBB = thumbnail.querySelector('.expanded-content-bb');
                expandedContentBB.classList.add('hidden');
                thumbnail.classList.remove('w-full'); // Restore original width
            }
        });
    </script>
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
        <div class="flex flex-wrap gap-4">
            @foreach ($episodes as $episode)
                <div class="thumbnail-wrapper flex flex-col w-64 cursor-pointer transition-all duration-300" data-index="{{ $episode->id }}" data-style="{{ strtolower($episode->style) }}">
                    <div class="expanded-content-tb hidden mt-4 p-4 w-full border border-black"></div>
                    <div class="image">
                        <img class="thumbnail" src="/coverart/{{ $episode->imageFilename }}.jpg"
                            alt="Cover art for {{ $episode->title }}" loading="lazy"/>
                    </div>
                    <div class="expanded-content hidden mt-4 p-4">
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
                                @if ($episode->twitchId && !$episode->twitchTooOld)
                                    <div class="button right twitch"><a href="https://twitch.tv/videos/{{ $episode->twitchId }}"><i
                                                class="fa-brands fa-twitch"></i> Twitch</a></div>
                                @endif
                                @if ($episode->youtubeId)
                                    <x-crate-button link="https://youtu.be/{{ $episode->youtubeId }}" icon="fa-brands fa-youtube" text="YouTube" color="youtube"/>
                                @endif
                            @endif
                            @if ($episode->mp3Filename)
                                <x-crate-button link="{{ asset('mp3/' . rawurlencode($episode->mp3Filename) . '.mp3') }}" icon="fa-solid fa-podcast" text="MP3" color="blue"/>
                            @endif
                        </div>
                    </div>
                    <div class="expanded-content-bb hidden mb-4 p-4 w-full border border-black"></div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
