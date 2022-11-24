<x-app-layout>
    @section('styles')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" ><!-- Some JS and styles -->
	@endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('messages.create') }}"> Create New message</a>
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
            <th>Header</th>
            <th>Message</th>
            <th>Active</th>

            <th>Action</th>
        </tr>
        @foreach ($messages as $message)
        <tr>
            <td>{{ $message->header }}</td>
            <td>{{ $message->message }}</td>
            <td>
                @if ($message->active)
                    <a href="{{ route('messages.deactivate',$message->id) }}"><i class="fa-solid fa-circle-check text-success"></i></a>
                @else
                    <a href="{{ route('messages.activate',$message->id) }}"><i class="fa-solid fa-circle-xmark text-danger"></i></a>
                @endif
            </td>
            <td>
                <form action="{{ route('messages.destroy',$message->id) }}" method="POST">
   
                    <a class="btn btn-primary" href="{{ route('messages.edit',$message->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-delete-left"></i></button>
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