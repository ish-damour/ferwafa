@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Add Result</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('fixtures.storeResult', $fixture->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Home Team: {{ $fixture->homeTeam->name }}</h3>
                            <div class="mb-3">
                                <label for="home_team_goals" class="form-label">Goals</label>
                                <input type="number" name="home_team_goals" class="form-control" value="{{ old('home_team_goals', $homeStats->goals) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_shots" class="form-label">Shots</label>
                                <input type="number" name="home_team_shots" class="form-control" value="{{ old('home_team_shots', $homeStats->shots) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_shots_on_target" class="form-label">Shots on Target</label>
                                <input type="number" name="home_team_shots_on_target" class="form-control" value="{{ old('home_team_shots_on_target', $homeStats->shots_on_target) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_possession" class="form-label">Possession (%)</label>
                                <input type="number" name="home_team_possession" class="form-control" value="{{ old('home_team_possession', $homeStats->possession) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_passes" class="form-label">Passes</label>
                                <input type="number" name="home_team_passes" class="form-control" value="{{ old('home_team_passes', $homeStats->passes) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_pass_accuracy" class="form-label">Pass Accuracy (%)</label>
                                <input type="number" name="home_team_pass_accuracy" class="form-control" value="{{ old('home_team_pass_accuracy', $homeStats->pass_accuracy) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_fouls" class="form-label">Fouls</label>
                                <input type="number" name="home_team_fouls" class="form-control" value="{{ old('home_team_fouls', $homeStats->fouls) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_yellow_cards" class="form-label">Yellow Cards</label>
                                <input type="number" name="home_team_yellow_cards" class="form-control" value="{{ old('home_team_yellow_cards', $homeStats->yellow_cards) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_red_cards" class="form-label">Red Cards</label>
                                <input type="number" name="home_team_red_cards" class="form-control" value="{{ old('home_team_red_cards', $homeStats->red_cards) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_offsides" class="form-label">Offsides</label>
                                <input type="number" name="home_team_offsides" class="form-control" value="{{ old('home_team_offsides', $homeStats->offsides) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="home_team_corners" class="form-label">Corners</label>
                                <input type="number" name="home_team_corners" class="form-control" value="{{ old('home_team_corners', $homeStats->corners) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Away Team: {{ $fixture->awayTeam->name }}</h3>
                            <div class="mb-3">
                                <label for="away_team_goals" class="form-label">Goals</label>
                                <input type="number" name="away_team_goals" class="form-control" value="{{ old('away_team_goals', $awayStats->goals) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_shots" class="form-label">Shots</label>
                                <input type="number" name="away_team_shots" class="form-control" value="{{ old('away_team_shots', $awayStats->shots) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_shots_on_target" class="form-label">Shots on Target</label>
                                <input type="number" name="away_team_shots_on_target" class="form-control" value="{{ old('away_team_shots_on_target', $awayStats->shots_on_target) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_possession" class="form-label">Possession (%)</label>
                                <input type="number" name="away_team_possession" class="form-control" value="{{ old('away_team_possession', $awayStats->possession) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_passes" class="form-label">Passes</label>
                                <input type="number" name="away_team_passes" class="form-control" value="{{ old('away_team_passes', $awayStats->passes) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_pass_accuracy" class="form-label">Pass Accuracy (%)</label>
                                <input type="number" name="away_team_pass_accuracy" class="form-control" value="{{ old('away_team_pass_accuracy', $awayStats->pass_accuracy) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_fouls" class="form-label">Fouls</label>
                                <input type="number" name="away_team_fouls" class="form-control" value="{{ old('away_team_fouls', $awayStats->fouls) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_yellow_cards" class="form-label">Yellow Cards</label>
                                <input type="number" name="away_team_yellow_cards" class="form-control" value="{{ old('away_team_yellow_cards', $awayStats->yellow_cards) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_red_cards" class="form-label">Red Cards</label>
                                <input type="number" name="away_team_red_cards" class="form-control" value="{{ old('away_team_red_cards', $awayStats->red_cards) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_offsides" class="form-label">Offsides</label>
                                <input type="number" name="away_team_offsides" class="form-control" value="{{ old('away_team_offsides', $awayStats->offsides) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="away_team_corners" class="form-label">Corners</label>
                                <input type="number" name="away_team_corners" class="form-control" value="{{ old('away_team_corners', $awayStats->corners) }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
