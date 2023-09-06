@extends('gallery.layout')


@section('meta')
    <meta property="og:title" content="niddelicious | nidde.nu | Generated image {{ $image_id }}" />
    <meta property="og:description"
        content="Image generated during a niddelicious live stream over on Twitch: https://twitch.tv/niddelicious" />
    <meta property="og:image" content="{{ url($lossy) }}" />
    <meta property="og:url" content="{{ url('/gallery/' . $image_id) }}" />
    <meta property="og:type" content="website" />
@endsection

@section('styles')
    <link href="{{ mix('css/style.css') }}" rel="stylesheet" />
@endsection

@section('footerScripts')
    <script src="{{ mix('js/gallery.js') }}"></script>
@endsection

@section('content')
    <div class="gallery-container" id="gallery-container">
        <div id="viewer" class="viewer">
            <div class="viewer-image">
                <img src="/{{ $lossy }}" loading="lazy" id="image" data-image="{{ $lossy }}" />
                <div class="image-prompt" id="image-prompt">
                </div>
                <div class="image-buttons">
                    <button class="image-button" id="infoButton" data-image="{{ $image }}"><i
                            class="fa-solid fa-circle-info"></i></button>
                    <button class="image-button" id="downloadButton" data-link="{{ $image }}"><i
                            class="fa-solid fa-download"></i></button>
                </div>
                <div class="sd-info" id="sd-info">
                    <div class="parameter">
                        <div class="label">Prompt:</div>
                        <div class="prompt" id="prompt"></div>
                    </div>
                    <div class="parameter">
                        <div class="label">Negative prompt:</div>
                        <div class="prompt" id="negative_prompt"></div>
                    </div>
                    <div class="settings">
                        <div class="settings-item">
                            <div class="label">Model:</div>
                            <div class="setting" id="model"></div>
                        </div>
                        <div class="settings-item">
                            <div class="label">Seed:</div>
                            <div class="setting" id="seed"></div>
                        </div>
                        <div class="settings-item">
                            <div class="label">Steps:</div>
                            <div class="setting" id="steps"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gallery">
            @foreach ($thumbnails as $date => $group)
                <div class="gallery-group">
                    {{ $date }}
                </div>
                <div class="gallery-thumbnails">
                    @foreach ($group as $thumbnail)
                        <div class="gallery-item">
                            <button class="galleryButton" data-image="{{ $thumbnail }}">
                                <img src="/{{ $thumbnail }}" loading="lazy" />
                            </button>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection
