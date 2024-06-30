@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Top Scorers</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player Name</th>
                        <th>Team Name</th>
                        <th>Goals</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topScorers as $index => $player)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->team->name }}</td>
                            <td>{{ $player->goals }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
