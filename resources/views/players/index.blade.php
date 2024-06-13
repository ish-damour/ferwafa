@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Players</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Team</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td>{{ $loop->iteration + ($players->currentPage() - 1) * $players->perPage() }}</td>
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->team->name }}</td>
                                <td>
                                    <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('players.destroy', $player->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Showing {{ $players->firstItem() }} to {{ $players->lastItem() }} of {{ $players->total() }} players
                    </div>
                    <div>
                        {{ $players->links() }}
                    </div>
                </div>
                <a href="{{ route('players.create') }}" class="btn btn-primary mt-3">Add New Player</a>
            </div>
        </div>
    </div>
</div>
@endsection
