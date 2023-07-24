@extends('gallery.layout')

@section('styles')
    <link href="{{ mix('css/style.css') }}" rel="stylesheet" />
@endsection

@section('footerScripts')
    <script src="{{ mix('js/gallery.js') }}"></script>
@endsection

@section('content')
    <div id="viewer" class="hidden viewer">
        <div class="viewer-item">
            <div class="sd-image">
                <a href="" target="_blank">
                    <img src="" />
                </a>
            </div>
            <div class="sd-info">
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
        @foreach ($thumbnails as $thumbnail)
            <div class="gallery-item">
                <button class="galleryButton" data-image="{{ $thumbnail }}">
                    <img src="{{ $thumbnail }}" />
                </button>
            </div>
        @endforeach
    </div>
@endsection
