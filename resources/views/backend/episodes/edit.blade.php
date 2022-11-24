<x-app-layout>
    @section('styles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Some JS and styles -->
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Episodes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <h2>Edit Episode</h2>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('episodes.index') }}"> Back</a>
                            </div>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('episodes.update', $episode->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    <input type="text" name="title" value="{{ $episode->title }}"
                                        class="form-control" placeholder="title">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Genre:</strong>
                                    <input type="text" class="form-control" name="genre" placeholder="Genre"
                                        value="{{ $episode->genre }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Style:</strong>
                                    <input type="text" class="form-control" name="style" placeholder="Style"
                                        value="{{ $episode->style }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Date:</strong>
                                    <input type="date" class="form-control" name="date" placeholder="2022-01-01"
                                        value="{{ $episode->date }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Image filename:</strong>
                                    <input type="text" class="form-control" name="imageFilename" placeholder="000"
                                        value="{{ $episode->imageFilename }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>YouTube ID:</strong>
                                    <input type="text" class="form-control" name="youtubeId" placeholder="YouTube ID"
                                        value="{{ $episode->youtubeId }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Twitch ID:</strong>
                                    <input type="text" class="form-control" name="twitchId" placeholder="Twitch ID"
                                        value="{{ $episode->twitchId }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Twitch-safe:</strong>
                                    <input type="checkbox" class="form-control" name="twitchSafe" value="1"
                                        {{ $episode->twitchSafe == 1 ? ' checked' : '' }}>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Featured:</strong>
                                    <input type="checkbox" class="form-control" name="featured" value="1"
                                        {{ $episode->featured == 1 ? ' checked' : '' }}>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Reddit ID:</strong>
                                    <input type="text" class="form-control" name="redditId" placeholder="Reddit ID"
                                        value="{{ $episode->redditId }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>MP3 filename:</strong>
                                    <input type="text" class="form-control" name="mp3Filename"
                                        placeholder="MP3 filename" value="{{ $episode->mp3Filename }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
