{{-- resources/views/fixtures/live.blade.php --}}
@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Live Fixtures</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Match Day</th>
                        <th>Home Team</th>
                        <th>Away Team</th>
                        <th>Match Date</th>
                        <th>Starting Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fixtures as $fixture)
                        <tr>
                            <td>{{ $fixture->match_day }}</td>
                            <td>{{ $fixture->homeTeam->name }}</td>
                            <td>{{ $fixture->awayTeam->name }}</td>
                            <td>{{ $fixture->match_date }}</td>
                            <td>{{ $fixture->starting_time }}</td>
                            <td>
                                @if($fixture->match_date <= now()->toDateString() && $fixture->starting_time <= now()->toTimeString())
                                    <a href="{{ route('fixtures.addResult', $fixture->id) }}" class="btn btn-primary">Update Live</a>
                                    <a href="{{ route('fixtures.endMatch', $fixture->id) }}" class="btn btn-success">Full Time</a>
                                @else
                                    <button class="btn btn-secondary" disabled>Update Live</button>
                                    <button class="btn btn-secondary" disabled>Full Time</button>
                                @endif
                                <form action="{{ route('fixtures.destroy', $fixture->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                <a href="{{ route('fixtures.edit', $fixture->id) }}" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
