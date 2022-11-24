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

                    <table class="table table-bordered">
                        <tr>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Style</th>
                            <th>Date</th>
                            <th>Image filename</th>
                            <th>YouTube ID</th>
                            <th>Twitch ID</th>
                            <th>Twitch-safe</th>
                            <th>Reddit ID</th>
                            <th>MP3 filename</th>

                            <th>Action</th>
                        </tr>
                        @foreach ($episodes as $episode)
                            <tr>
                                <td>{{ $episode->title }}</td>
                                <td>{{ $episode->genre }}</td>
                                <td>{{ $episode->style }}</td>
                                <td>{{ $episode->date }}</td>
                                <td>{{ $episode->imageFilename }}</td>
                                <td>{{ $episode->youtubeId }}</td>
                                <td>{{ $episode->twitchId }}</td>
                                <td>{{ $episode->twitchSafe }}</td>
                                <td>{{ $episode->redditId }}</td>
                                <td>{{ $episode->mp3Filename }}</td>
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
