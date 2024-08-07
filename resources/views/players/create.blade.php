@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Add New Player</h1>
                <form action="{{ route('players.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Player Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="team_id" class="form-label">Team</label>
                        <select class="form-control" id="team_id" name="team_id" required>
                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
