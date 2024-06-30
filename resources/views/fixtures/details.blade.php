@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="p-4 shadow-lg">
                <h1 class="mb-4">Fixture Details</h1>
                <h2>{{ $fixture->homeTeam->name }} vs {{ $fixture->awayTeam->name }}</h2>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Home Team</th>
                            <th>Statistic</th>
                            <th>Away Team</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if($homeGoals->isEmpty())
                                    0
                                @else
                                <strong>{{ $homeStats->goals }}</strong>
                                    @foreach($homeGoals as $goal)
                                    <span class="text-muted">{{ $goal->name }} ({{ $goal->minute }}')</span>
                                        @if(!$loop->last)
                                            , 
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>Goals</td>
                            <td>
                                @if($awayGoals->isEmpty())
                                    0
                                @else
                                <strong>{{ $awayStats->goals }}</strong> 
                                    @foreach($awayGoals as $goal)
                                        <span class="text-muted">{{ $goal->name }} ({{ $goal->minute }}')</span>
                                        @if(!$loop->last)
                                            , 
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if($homeRedCards->isEmpty())
                                    0
                                @else
                                <strong>{{ $homeStats->red_cards }}</strong>
                                    @foreach($homeRedCards as $card)
                                    <span class="text-muted"> {{ $card->name }} ({{ $card->minute }}')</span>
                                        @if(!$loop->last)
                                            , 
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>Red Cards</td>
                            <td>
                                @if($awayRedCards->isEmpty())
                                    0
                                @else
                                <strong>{{ $awayStats->red_cards }}</strong>
                                    @foreach($awayRedCards as $card)
                                    <span class="text-muted"> {{ $card->name }} ({{ $card->minute }}')</span>
                                        @if(!$loop->last)
                                            , 
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->shots }}</td>
                            <td>Shots</td>
                            <td>{{ $awayStats->shots }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->shots_on_target }}</td>
                            <td>Shots on Target</td>
                            <td>{{ $awayStats->shots_on_target }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->possession }}</td>
                            <td>Possession (%)</td>
                            <td>{{ $awayStats->possession }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->passes }}</td>
                            <td>Passes</td>
                            <td>{{ $awayStats->passes }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->pass_accuracy }}</td>
                            <td>Pass Accuracy (%)</td>
                            <td>{{ $awayStats->pass_accuracy }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->fouls }}</td>
                            <td>Fouls</td>
                            <td>{{ $awayStats->fouls }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->yellow_cards }}</td>
                            <td>Yellow Cards</td>
                            <td>{{ $awayStats->yellow_cards }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->red_cards }}</td>
                            <td>Red Cards</td>
                            <td>{{ $awayStats->red_cards }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->offsides }}</td>
                            <td>Offsides</td>
                            <td>{{ $awayStats->offsides }}</td>
                        </tr>
                        <tr>
                            <td>{{ $homeStats->corners }}</td>
                            <td>Corners</td>
                            <td>{{ $awayStats->corners }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
