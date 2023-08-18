@extends('gallery.layout')

@section('styles')
    <link href="{{ mix('css/style.css') }}" rel="stylesheet" />
@endsection

@section('footerScripts')
    <script src="{{ mix('js/gallery.js') }}"></script>
@endsection

@section('content')
    <div class="gallery-container" id="gallery-container">
        <div id="viewer" class="viewer">
            <div class="viewer-item">
                <div class="sd-image">
                    <a href="{{ $image }}" target="_blank">
                        <img src="{{ $lossy }}" loading="lazy" />
                    </a>
                </div>
            </div>
        </div>
        <div class="gallery">
            <div class="gallery-thumbnails">
            @foreach ($thumbnails as $thumbnail)
                <div class="gallery-item">
                    <button class="galleryButton" data-image="{{ $thumbnail }}">
                        <img src="{{ $thumbnail }}" loading="lazy" />
                    </button>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection
