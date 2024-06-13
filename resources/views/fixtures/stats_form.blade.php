@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Add Yellow cards</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('fixtures.storePlayerStats', $fixture->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Home Team: {{ $fixture->homeTeam->name }}</h3>
                            <div class="mb-3">
                                <label for="home_team_yellow_cards" class="form-label">Yellow Cards: {{ old('home_team_yellow_cards', $homeStats->yellow_cards) }}</label>
                                <input type="number" name="home_team_yellow_cards" class="form-control" value="" required>
                            </div>
                            @if ($homePlayers->count() > 0)
                                <div class="mb-3">
                                    <label for="home_team_yellow_card_players" class="form-label">Select player:</label>
                                    <select name="home_team_yellow_card_players" class="form-select">
                                        <option value="">SELECT PLAYER</option>
                                        @foreach ($homePlayers as $player)
                                            <option value="{{ $player->id }}">{{ $player->name }}({{ $player->yellow_cards }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h3>Away Team: {{ $fixture->awayTeam->name }}</h3>
                            <div class="mb-3">
                                <label for="away_team_yellow_cards" class="form-label">Yellow Cards: {{ old('away_team_yellow_cards', $awayStats->yellow_cards) }}</label>
                                <input type="number" name="away_team_yellow_cards" class="form-control" value="" required>
                            </div>
                            @if ($awayPlayers->count() > 0)
                                <div class="mb-3">
                                    <label for="away_team_yellow_card_players" class="form-label">Select player:</label>
                                    <select name="away_team_yellow_card_players" class="form-select">
                                        <option value="">SELECT PLAYER</option>
                                        @foreach ($awayPlayers as $player)
                                            <option value="{{ $player->id }}">{{ $player->name }}({{ $player->yellow_cards }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save & Next</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
