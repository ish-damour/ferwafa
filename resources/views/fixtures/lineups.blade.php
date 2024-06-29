{{-- resources/views/fixtures/lineups.blade.php --}}
@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Lineups for Fixture: {{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</h1>
        </div>
    </div>
    <div class="row">
        <!-- Home Team Lineup -->
        <div class="col-md-6">
            <h2>Home Team: {{ $fixture->homeTeam->name }}</h2>
            <ul class="list-group mb-4">
                @foreach ($homeTeamPlayers as $player)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $player->name }}
                        @if ($ineligibleHomePlayers->has($player->id))
                            <span class="badge bg-danger">Ineligible (Reason: {{ $ineligibleHomePlayers->get($player->id)->reason }})</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Away Team Lineup -->
        <div class="col-md-6">
            <h2>Away Team: {{ $fixture->awayTeam->name }}</h2>
            <ul class="list-group mb-4">
                @foreach ($awayTeamPlayers as $player)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $player->name }}
                        @if ($ineligibleAwayPlayers->has($player->id))
                            <span class="badge bg-danger">Ineligible (Reason: {{ $ineligibleAwayPlayers->get($player->id)->reason }})</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="mt-4">
            <a href="{{ route('fixtures.index') }}" class="btn btn-secondary">Back to Fixtures</a>
        </div>
    </div>
</div>
@endsection
