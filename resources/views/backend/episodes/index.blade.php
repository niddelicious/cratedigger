<x-app-layout>
    @section('styles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Some JS and styles -->
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

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Episodes') }}
        </h2>
    </x-slot>

    <div class="py-12" id="main-content">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-right">
                                <a class="btn btn-success" href="{{ route('episodes.create') }}"> Create New episode</a>
                            </div>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th scope="col" class="col-1">Id</th>
                                <th scope="col" class="col-8">Data</th>
                                <th scope="col" class="col-2">Thumbnail</th>

                                <th scope="col" class="col-1">Action</th>
                            </tr>
                        </thead>
                        @foreach ($episodes as $episode)
                            <tr>
                                <th scope="row">{{ $episode->id }}</th>
                                <td>
                                    <ul>
                                        <li><em>Title:</em> {{ $episode->title }}</li>
                                        <li><em>Date:</em> {{ $episode->date }}</li>
                                        <li><em>Style:</em> {{ $episode->style }}</li>
                                        <li><em>Genre:</em> {{ $episode->genre }}</li>
                                        <li><em>Filename:</em> {{ $episode->mp3Filename }}</li>
                                        @if ($episode->youtubeId)
                                            <li><i class="fa-brands fa-youtube"></i>: {{ $episode->youtubeId }}</li>
                                        @endif
                                        @if ($episode->twitchId)
                                            <li><i class="fa-brands fa-twitch"></i>: {{ $episode->twitchId }}
                                                @if ($episode->twitchSafe == true)
                                                    <i class="fa-solid fa-shield-heart"></i>
                                                @endif
                                            </li>
                                        @endif
                                        @if ($episode->redditId)
                                            <li><i class="fa-brands fa-reddit"></i>: {{ $episode->redditId }}</li>
                                        @endif
                                    </ul>

                                </td>
                                <td>
                                    <img src="/coverart/{{ $episode->imageFilename }}.jpg" class="b-lazy"
                                        data-src="/coverart/{{ $episode->imageFilename }}.jpg" 
                                        alt="Cover art for id {{ $episode->id }}" />
                                </td>
                                <td>
                                    <form action="{{ route('episodes.destroy', $episode->id) }}" method="POST">

                                        <a class="btn btn-primary" href="{{ route('episodes.edit', $episode->id) }}"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger"><i
                                                class="fa-solid fa-delete-left"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
