@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Teams</h1>
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
                            <th>Played Matches</th>
                            <th>Points</th>
                            <th>Goal Difference</th>
                            <th>Goals Scored</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $index => $team)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->played_matches }}</td>
                                <td>{{ $team->points }}</td>
                                <td>{{ $team->goal_difference }}</td>
                                <td>{{ $team->goals_scored }}</td>
                                <td>
                                    @if ($team->played_matches>=1)
                                    <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning btn-sm disabled">Edit</a>
                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" disabled>Delete</button>
                                    </form>    
                                    @else
                                    <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('teams.destroy', $team->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>                                     
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('teams.create') }}" class="btn btn-primary mt-3">Add New Team</a>
            </div>
        </div>
    </div>
</div>
@endsection
