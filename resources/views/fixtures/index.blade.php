{{-- resources/views/fixtures/index.blade.php --}}
@extends('layout')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Fixtures</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="mb-4">
                <button id="prev" class="btn btn-primary" style="display: none;">&lt;</button>
                <ul class="nav d-inline-block" id="days-nav" style="white-space: nowrap; overflow-x: auto; max-width: 900px;">
                    @for ($i = 1; $i <= 30; $i++)
                        <li class="nav-item d-inline-block">
                            <a class="nav-link {{ isset($day) && $day == $i ? 'active' : '' }}" href="{{ route('fixtures.byDay', $i) }}">D{{ $i }}</a>
                        </li>
                    @endfor
                </ul>
            </div>

            @auth
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
                <tbody id="fixtures-tbody">
                    @foreach($fixtures as $fixture)
                        @php
                            $matchDate = \Carbon\Carbon::parse($fixture->match_date);
                            $currentDate = \Carbon\Carbon::now()->startOfDay();
                            $matchDateTime = \Carbon\Carbon::parse($fixture->match_date . ' ' . $fixture->starting_time);
                        @endphp
                        <tr>
                            <td>{{ $fixture->match_day }}</td>
                            <td>{{ $fixture->homeTeam->name }}</td>
                            <td>{{ $fixture->awayTeam->name }}</td>
                            <td>{{ $fixture->match_date }}</td>
                            <td>{{ $fixture->starting_time }}</td>
                            <td>
                                @if($matchDate->lessThanOrEqualTo($currentDate)  && ($matchDate->isToday() ? \Carbon\Carbon::parse($fixture->starting_time)->lessThanOrEqualTo(now()->format('H:i:s')) : true))
                                @if ($fixture->status=="ended")
                                <button class="btn btn-warning" disabled>{{$fixture->result}}</button>
                                @else 
                                  <a href="{{ route('fixtures.addResult', $fixture->id) }}" class="btn btn-primary">Add Result</a>
                                @endif   
                                
                                @else
                                    <button class="btn btn-secondary" disabled>Add Result</button>
                                @endif
                                <a href="{{ route('fixtures.showLineups', $fixture->id) }}" class="btn btn-info">Lineups</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endauth
            
            @guest
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td colspan="5">
                            <form id="search-form">
                                <input type="text" id="search-input" placeholder="search team" class="form-control">
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <th>Home Team</th>
                        <th>Result</th>
                        <th>Away Team</th>
                        <th>Date and Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="fixtures-tbody">
                    @foreach($fixtures as $fixture)
                        @php
                            $matchDate = \Carbon\Carbon::parse($fixture->match_date);
                            $status = $fixture->status;
                            $full="ended";
                            $currentDate = \Carbon\Carbon::now()->startOfDay();
                            $matchDateTime = \Carbon\Carbon::parse($fixture->match_date . ' ' . $fixture->starting_time);
                        @endphp
                        <tr>
                            <td>{{ $fixture->homeTeam->name }}</td>
                            <td class="text-center">
                                @if ($status == $full)
                                    {{ $fixture->result }}
                                @else
                                    VS
                                @endif
                            </td>
                            <td>{{ $fixture->awayTeam->name }}</td>
                            <td>{{ $fixture->match_date }} {{ $fixture->starting_time }}</td>
                            <td><a href="{{ route('fixtures.showLineups', $fixture->id) }}" class="btn btn-info">Lineups</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endguest
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('search-input').addEventListener('input', function(e) {
    const query = e.target.value;

    fetch(`/fixtures/search?query=${query}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('fixtures-tbody');
            tbody.innerHTML = '';

            data.forEach(fixture => {
                const row = document.createElement('tr');

                const homeTeamCell = document.createElement('td');
                homeTeamCell.textContent = fixture.home_team.name;
                row.appendChild(homeTeamCell);

                const resultCell = document.createElement('td');
                resultCell.className = 'text-center';
                resultCell.textContent = fixture.status === 'ended' ? fixture.result : 'VS';
                row.appendChild(resultCell);

                const awayTeamCell = document.createElement('td');
                awayTeamCell.textContent = fixture.away_team.name;
                row.appendChild(awayTeamCell);

                const dateTimeCell = document.createElement('td');
                dateTimeCell.textContent = `${fixture.match_date} ${fixture.starting_time}`;
                row.appendChild(dateTimeCell);

                tbody.appendChild(row);
            });
        });
});
</script>
@endsection
