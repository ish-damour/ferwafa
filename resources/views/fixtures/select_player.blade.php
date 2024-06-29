@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Select Player</h1>
            <!-- Form for Goals -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('fines.store') }}" method="POST" class="mt-5">
                @csrf
                <input type="hidden" name="fixture_id" value="{{ $fixture->id }}">
                <div class="row">
                    @for ($i = 0; $i < $events['home_goals']; $i++)
                        <div class="col-md-6 mb-3">
                            <label for="home_goal_player_{{ $i }}" class="form-label">Home Goal Player {{ $i + 1 }}</label>
                            <select name="home_goal_player_{{ $i }}" id="home_goal_player_{{ $i }}" class="form-control" required>
                                @foreach($homePlayers as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="home_goal_minute_{{ $i }}" placeholder="Minute" class="form-control" required>
                        </div>
                    @endfor

                    @for ($i = 0; $i < $events['away_goals']; $i++)
                        <div class="col-md-6 mb-3">
                            <label for="away_goal_player_{{ $i }}" class="form-label">Away Goal Player {{ $i + 1 }}</label>
                            <select name="away_goal_player_{{ $i }}" id="away_goal_player_{{ $i }}" class="form-control" required>
                                @foreach($awayPlayers as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="away_goal_minute_{{ $i }}" placeholder="Minute" class="form-control" required>
                        </div>
                    @endfor
                </div>
                {{-- <button type="submit" class="btn btn-primary">Submit Goals</button> --}}
            {{-- </form> --}}

            <!-- Form for Red Cards -->
            {{-- <form action="{{ route('fines.store') }}" method="POST" class="mt-5"> --}}
                @csrf
                <input type="hidden" name="fixture_id" value="{{ $fixture->id }}">
                <div class="row">
                    @for ($i = 0; $i < $events['home_red_cards']; $i++)
                        <div class="col-md-6 mb-3">
                            <label for="home_red_card_player_{{ $i }}" class="form-label">Home Red Card Player {{ $i + 1 }}</label>
                            <select name="home_red_card_player_{{ $i }}" id="home_red_card_player_{{ $i }}" class="form-control" required>
                                @foreach($homePlayers as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="home_red_card_reason_{{ $i }}" value="Red Card">
                            <input type="number" name="home_red_card_minute_{{ $i }}" placeholder="Minute" class="form-control" required>
                        </div>
                    @endfor

                    @for ($i = 0; $i < $events['away_red_cards']; $i++)
                        <div class="col-md-6 mb-3">
                            <label for="away_red_card_player_{{ $i }}" class="form-label">Away Red Card Player {{ $i + 1 }}</label>
                            <select name="away_red_card_player_{{ $i }}" id="away_red_card_player_{{ $i }}" class="form-control" required>
                                @foreach($awayPlayers as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="away_red_card_reason_{{ $i }}" value="Red Card">
                            <input type="number" name="away_red_card_minute_{{ $i }}" placeholder="Minute" class="form-control" required>
                        </div>
                    @endfor
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
