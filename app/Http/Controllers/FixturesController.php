<?php

namespace App\Http\Controllers;
use App\Models\Fine;
use App\Models\Team;
use App\Models\Goal;
use App\Models\Fixture;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FixtureStat;
use Illuminate\Support\Facades\DB; 
  use App\Models\HomeFixtureStat;
    use App\Models\AwayFixtureStat;
    use App\Models\Player;

class FixturesController extends Controller
{
 
    
    public function index()
    {
        $fixtures = Fixture::with('homeTeam', 'awayTeam')->get();
        
        // Update fixture status if match_date and starting_time conditions are met
        foreach ($fixtures as $fixture) {
            $matchDateTime = Carbon::parse($fixture->match_date . ' ' . $fixture->starting_time);
            if ($matchDateTime->lessThanOrEqualTo(Carbon::now()) && $fixture->status != 'ended') {
                $fixture->status = 'started';
                $fixture->save();
    
                // Add data to home_fixtures_stats table
                HomeFixtureStat::create([
                    'fixture_id' => $fixture->id,
                    'team_id' => $fixture->home_team_id,
                    'shots' => 0,
                    'shots_on_target' => 0,
                    'possession' => 0,
                    'passes' => 0,
                    'pass_accuracy' => 0,
                    'fouls' => 0,
                    'yellow_cards' => 0,
                    'red_cards' => 0,
                    'offsides' => 0,
                    'corners' => 0,
                    'goals' => 0,
                ]);
    
                // Add data to away_fixtures_stats table
                AwayFixtureStat::create([
                    'fixture_id' => $fixture->id,
                    'team_id' => $fixture->away_team_id,
                    'shots' => 0,
                    'shots_on_target' => 0,
                    'possession' => 0,
                    'passes' => 0,
                    'pass_accuracy' => 0,
                    'fouls' => 0,
                    'yellow_cards' => 0,
                    'red_cards' => 0,
                    'offsides' => 0,
                    'corners' => 0,
                    'goals' => 0,
                ]);
            }
        }
    
        return view('fixtures.index', compact('fixtures'));
    }
    
    public function showGenerateForm()
    {
        return view('fixtures.generate');
    }

    public function generateFixtures(Request $request)
    {
        // Validate request inputs
        $request->validate([
            'startDate' => 'required|date',
            'firsttime' => 'required|date_format:H:i',
            'secondtime' => 'required|date_format:H:i',
            'thirdtime' => 'required|date_format:H:i',
            'matchDayInterval' => 'required|integer|min:1',
        ]);
    
        // Retrieve and concatenate match times
        $firsttime = $request->firsttime;
        $secondtime = $request->secondtime;
        $thirdtime = $request->thirdtime;
        $fulltime = $firsttime . ',' . $secondtime . ',' . $thirdtime;
    
        // Parse the start date and match times
        $startDate = Carbon::parse($request->startDate);
        $matchTimes = explode(',', $fulltime);
        $matchDayInterval = (int)$request->matchDayInterval;
    
        // Retrieve and shuffle teams
        $teams = Team::all()->shuffle();
        $teamCount = $teams->count();
    
        if ($teamCount < 2) {
            return back()->with('error', 'Not enough teams to generate fixtures');
        }
    
        // Initialize fixtures array
        $fixtures = [];
        $matchesPerDay = 4; // Maximum of 4 matches per day
        $currentMatchDayDate = $startDate->copy();
    
        // Generate fixtures
        for ($matchDay = 1; $matchDay <= 30; $matchDay++) {
            $matchCount = 0;
    
            for ($match = 0; $match < $teamCount / 2; $match++) {
                if ($matchCount >= $matchesPerDay) {
                    $currentMatchDayDate->addDay(); // Move to next day if more than 4 matches
                    $matchCount = 0;
                }
    
                $homeTeamIndex = ($matchDay + $match) % $teamCount;
                $awayTeamIndex = ($matchDay + $teamCount - $match - 1) % $teamCount;
    
                $homeTeam = $teams[$homeTeamIndex];
                $awayTeam = $teams[$awayTeamIndex];
    
                $matchTime = $matchTimes[$match % count($matchTimes)]; // Cycle through match times
    
                $fixtures[] = [
                    'match_day' => $matchDay,
                    'home_team_id' => $homeTeam->id,
                    'away_team_id' => $awayTeam->id,
                    'match_date' => $currentMatchDayDate->toDateString(), // Date only
                    'starting_time' => $matchTime, // Time only
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
    
                $matchCount++;
            }
    
            $currentMatchDayDate->addDays($matchDayInterval); // Move to the next match day after one week
        }
    
        // Insert fixtures into the database
        DB::table('fixtures')->insert($fixtures);
    
        // Redirect with success message
        return redirect()->route('fixtures.index')->with('success', 'Fixtures generated successfully');
    }
    


    public function addResult($id)
{
    $fixture = Fixture::with('homeTeam', 'awayTeam')->findOrFail($id);
    $homeStats = HomeFixtureStat::where('fixture_id', $id)->first();
    $awayStats = AwayFixtureStat::where('fixture_id', $id)->first();

    return view('fixtures.add_result', compact('fixture', 'homeStats', 'awayStats'));
}

    public function statsForm(Fixture $fixture)
    {
        // Assuming you have logic to determine home and away team players
        $homePlayers = Player::where('team_id', $fixture->home_team_id)->get();
        $awayPlayers = Player::where('team_id', $fixture->away_team_id)->get();
                // Retrieve home and away stats for the fixture
                $homeStats = HomeFixtureStat::where('fixture_id', $fixture->id)->first();
                $awayStats = AwayFixtureStat::where('fixture_id', $fixture->id)->first();
        
                return view('fixtures.stats_form', compact('fixture', 'homePlayers','awayPlayers','homeStats', 'awayStats'));
            

        

        // return view('fixtures.stats_form', compact('fixture', 'homePlayers', 'awayPlayers'));
    }

    public function showLineups($id)
{
    $fixture = Fixture::findOrFail($id);
    $matchDay = $fixture->match_day;

    // Get all home team players
    $homeTeamPlayers = $fixture->homeTeam->players;

    // Get all away team players
    $awayTeamPlayers = $fixture->awayTeam->players;

    // Fetch fines for the fixture's match day
    $ineligibleHomePlayers = Fine::whereIn('player_id', $homeTeamPlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->get()
        ->keyBy('player_id');

    $ineligibleAwayPlayers = Fine::whereIn('player_id', $awayTeamPlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->get()
        ->keyBy('player_id');

    return view('fixtures.lineups', compact('fixture', 'homeTeamPlayers', 'awayTeamPlayers', 'ineligibleHomePlayers', 'ineligibleAwayPlayers'));
}


    
public function storeResult(Request $request, $id)
{
    $fixture = Fixture::findOrFail($id);
    $homeStats = HomeFixtureStat::where('fixture_id', $fixture->id)->first();
    $awayStats = AwayFixtureStat::where('fixture_id', $fixture->id)->first();

    // Update fixture with the result
    $fixture->home_team_goals = $request->home_team_goals;
    $fixture->away_team_goals = $request->away_team_goals;
    $fixture->status = "ended";
    $fixture->result = $request->home_team_goals . '-' . $request->away_team_goals;
    $fixture->save();

    // Update home team fixture stats
    $homeStats->update([
        'goals' => $request->home_team_goals,
        'shots' => $request->home_team_shots,
        'shots_on_target' => $request->home_team_shots_on_target,
        'possession' => $request->home_team_possession,
        'passes' => $request->home_team_passes,
        'pass_accuracy' => $request->home_team_pass_accuracy,
        'fouls' => $request->home_team_fouls,
        'yellow_cards' => $request->home_team_yellow_cards,
        'red_cards' => $request->home_team_red_cards,
        'offsides' => $request->home_team_offsides,
        'corners' => $request->home_team_corners,
    ]);

    // Update away team fixture stats
    $awayStats->update([
        'goals' => $request->away_team_goals,
        'shots' => $request->away_team_shots,
        'shots_on_target' => $request->away_team_shots_on_target,
        'possession' => $request->away_team_possession,
        'passes' => $request->away_team_passes,
        'pass_accuracy' => $request->away_team_pass_accuracy,
        'fouls' => $request->away_team_fouls,
        'yellow_cards' => $request->away_team_yellow_cards,
        'red_cards' => $request->away_team_red_cards,
        'offsides' => $request->away_team_offsides,
        'corners' => $request->away_team_corners,
    ]);

    // Update team statistics
    $homeTeam = $fixture->homeTeam;
    $awayTeam = $fixture->awayTeam;

    $homeTeam->played_matches += 1;
    $awayTeam->played_matches += 1;

    $homeTeam->goals_scored += $request->home_team_goals;
    $awayTeam->goals_scored += $request->away_team_goals;

    $homeTeam->goals_conceded += $request->away_team_goals;
    $awayTeam->goals_conceded += $request->home_team_goals;

    $homeTeam->goal_difference = $homeTeam->goals_scored - $homeTeam->goals_conceded;
    $awayTeam->goal_difference = $awayTeam->goals_scored - $awayTeam->goals_conceded;

    if ($request->home_team_goals > $request->away_team_goals) {
        $homeTeam->points += 3;
    } elseif ($request->home_team_goals < $request->away_team_goals) {
        $awayTeam->points += 3;
    } else {
        $homeTeam->points += 1;
        $awayTeam->points += 1;
    }

    $homeTeam->save();
    $awayTeam->save();

    if ($request->home_team_red_cards > 0 || $request->away_team_red_cards > 0 || $request->home_team_goals > 0 || $request->away_team_goals > 0) {
        $events = [
            'home_goals' => $request->home_team_goals,
            'away_goals' => $request->away_team_goals,
            'home_red_cards' => $request->home_team_red_cards,
            'away_red_cards' => $request->away_team_red_cards
        ];
        return redirect()->route('fixtures.selectPlayer', ['fixture' => $fixture->id, 'events' => $events]);
    }

    return redirect()->route('fixtures.index')->with('success', 'Result added successfully!');
}

public function sselectPlayer($fixtureId, Request $request)
{
    $fixture = Fixture::findOrFail($fixtureId);
    $homePlayers = Player::where('team_id', $fixture->home_team_id)->get();
    $awayPlayers = Player::where('team_id', $fixture->away_team_id)->get();
    $events = $request->events;

    return view('fixtures.select_player', compact('fixture', 'homePlayers', 'awayPlayers', 'events'));
}




    


        // FixturesController.php

public function live()
{
    $fixtures = Fixture::where('match_date', '<=', now()->toDateString())
                        ->where('starting_time', '<=', now()->toTimeString())
                        ->where('status', 'started')
                        ->get();

    return view('fixtures.live', compact('fixtures'));
}

public function updateLive($id, Request $request)
{
    $fixture = Fixture::findOrFail($id);
    // Update live stats logic here
    // You need to add validation and updating logic

    return back()->with('success', 'Live stats updated successfully');
}

public function endMatch($id)
{
    $fixture = Fixture::findOrFail($id);
    $fixture->status = 'ended';
    $fixture->save();

    return redirect()->route('fixtures.live')->with('success', 'Match ended successfully');
}
public function storePlayerStats(Request $request, Fixture $fixture)
    {
        $request->validate([
            'home_goals' => 'required|array',
            'home_goals.*' => 'numeric|min:0',
            'home_yellow_cards' => 'required|array',
            'home_yellow_cards.*' => 'numeric|min:0',
            'home_red_cards' => 'required|array',
            'home_red_cards.*' => 'numeric|min:0',
            'away_goals' => 'required|array',
            'away_goals.*' => 'numeric|min:0',
            'away_yellow_cards' => 'required|array',
            'away_yellow_cards.*' => 'numeric|min:0',
            'away_red_cards' => 'required|array',
            'away_red_cards.*' => 'numeric|min:0',
        ]);

        foreach ($request->home_goals as $playerId => $goals) {
            // Store home team player stats
            $player = Player::findOrFail($playerId);
            // Update or store stats as needed
            // Example:
            // $player->goals += $goals;
            // $player->save();
        }

        foreach ($request->away_goals as $playerId => $goals) {
            // Store away team player stats
            $player = Player::findOrFail($playerId);
            // Update or store stats as needed
        }

        // Redirect back or to next section
        return redirect()->back()->with('success', 'Player statistics saved successfully');
    }

    public function indexByDay($day)
    {
        $fixtures = Fixture::with('homeTeam', 'awayTeam')
            ->where('match_day', $day)
            ->get();

        return view('fixtures.index', compact('fixtures', 'day'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $teams = Team::where('name', 'LIKE', "%$query%")->pluck('id');
        $fixtures = Fixture::whereIn('home_team_id', $teams)
            ->orWhereIn('away_team_id', $teams)
            ->with('homeTeam', 'awayTeam')
            ->get();

        return response()->json($fixtures);
    }

    
    
    
    public function storeGoals(Request $request)
{
    $fixtureId = $request->input('fixture_id');
    
    foreach ($request->all() as $key => $value) {
        if (str_starts_with($key, 'home_goal_player_') || str_starts_with($key, 'away_goal_player_')) {
            $playerId = $value;
            $minuteKey = str_replace('player', 'minute', $key);
            $minute = $request->input($minuteKey);
            
            Goal::create([
                'player_id' => $playerId,
                'fixture_id' => $fixtureId,
                'minute' => $minute,
            ]);

            Player::find($playerId)->increment('goals');
        }
    }

    

    return redirect()->back()->with('success', 'Goals added successfully!');

}


public function storeFines(Request $request)
{
    $fixtureId = $request->input('fixture_id');
    $fixture = Fixture::find($fixtureId);
    $matchDay = $fixture->match_day;

    // Get all home and away team players
    $homeTeamPlayers = $fixture->homeTeam->players;
    $awayTeamPlayers = $fixture->awayTeam->players;

    // Fetch fines for the fixture's match day
    $ineligibleHomePlayers = Fine::whereIn('player_id', $homeTeamPlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->pluck('player_id')
        ->toArray();

    $ineligibleAwayPlayers = Fine::whereIn('player_id', $awayTeamPlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->pluck('player_id')
        ->toArray();

    // Process Red Cards
    foreach ($request->all() as $key => $value) {
        if (str_starts_with($key, 'home_red_card_player_') || str_starts_with($key, 'away_red_card_player_')) {
            $playerId = $value;
            $minuteKey = str_replace('player', 'minute', $key);
            $minute = $request->input($minuteKey);

            if (in_array($playerId, $ineligibleHomePlayers) || in_array($playerId, $ineligibleAwayPlayers)) {
                return redirect()->back()->with('error', 'Player is ineligible to play in this match.');
            }

            Fine::create([
                'player_id' => $playerId,
                'fixture_id' => $fixtureId,
                'match_day_ineligible' => $matchDay + 1,
                'reason' => 'Red Card',
                'minute' => $minute,
            ]);

            Player::find($playerId)->increment('red_cards');
        }
    }

    // Process Goals
    foreach ($request->all() as $key => $value) {
        if (str_starts_with($key, 'home_goal_player_') || str_starts_with($key, 'away_goal_player_')) {
            $playerId = $value;
            $minuteKey = str_replace('player', 'minute', $key);
            $minute = $request->input($minuteKey);

            if (in_array($playerId, $ineligibleHomePlayers) || in_array($playerId, $ineligibleAwayPlayers)) {
                return redirect()->back()->with('error', 'Player is ineligible to play in this match.');
            }

            Goal::create([
                'player_id' => $playerId,
                'fixture_id' => $fixtureId,
                'minute' => $minute,
            ]);

            Player::find($playerId)->increment('goals');
        }
    }

    return redirect()->route('fixtures.index')->with('success', 'Goals and red cards processed successfully!');

}

public function showDetails($id)
{
    $fixture = Fixture::findOrFail($id);
    $homeStats = HomeFixtureStat::where('fixture_id', $id)->first();
    $awayStats = AwayFixtureStat::where('fixture_id', $id)->first();

    // Get goals for home team
    $homeGoals = DB::table('goals')
        ->join('players', 'goals.player_id', '=', 'players.id')
        ->where('goals.fixture_id', $id)
        ->where('players.team_id', $fixture->home_team_id)
        ->select('players.name', 'goals.minute')
        ->get();

    // Get goals for away team
    $awayGoals = DB::table('goals')
        ->join('players', 'goals.player_id', '=', 'players.id')
        ->where('goals.fixture_id', $id)
        ->where('players.team_id', $fixture->away_team_id)
        ->select('players.name', 'goals.minute')
        ->get();

    // Get red cards for home team
    $homeRedCards = DB::table('fines')
        ->join('players', 'fines.player_id', '=', 'players.id')
        ->where('fines.fixture_id', $id)
        ->where('players.team_id', $fixture->home_team_id)
        ->where('fines.reason', 'Red Card')
        ->select('players.name', 'fines.minute')
        ->get();

    // Get red cards for away team
    $awayRedCards = DB::table('fines')
        ->join('players', 'fines.player_id', '=', 'players.id')
        ->where('fines.fixture_id', $id)
        ->where('players.team_id', $fixture->away_team_id)
        ->where('fines.reason', 'Red Card')
        ->select('players.name', 'fines.minute')
        ->get();

    return view('fixtures.details', compact('fixture', 'homeStats', 'awayStats', 'homeGoals', 'awayGoals', 'homeRedCards', 'awayRedCards'));
}


public function selectPlayer($fixtureId, Request $request)
{
    $fixture = Fixture::findOrFail($fixtureId);
    $homePlayers = Player::where('team_id', $fixture->home_team_id)->get();
    $awayPlayers = Player::where('team_id', $fixture->away_team_id)->get();
    $events = $request->events;

    // Get match day for the current fixture
    $matchDay = $fixture->match_day;

    // Fetch fines for the fixture's match day
    $ineligibleHomePlayers = Fine::whereIn('player_id', $homePlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->get()
        ->keyBy('player_id');

    $ineligibleAwayPlayers = Fine::whereIn('player_id', $awayPlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->get()
        ->keyBy('player_id');

    return view('fixtures.select_player', compact('fixture', 'homePlayers', 'awayPlayers', 'events', 'ineligibleHomePlayers', 'ineligibleAwayPlayers'));
}






public function showSelectPlayer($fixtureId)
{
    $fixture = Fixture::findOrFail($fixtureId);
    $matchDay = $fixture->match_day;

    // Get all home team players
    $homePlayers = $fixture->homeTeam->players;

    // Get all away team players
    $awayPlayers = $fixture->awayTeam->players;

    // Fetch fines for the fixture's match day
    $ineligibleHomePlayers = Fine::whereIn('player_id', $homePlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->get()
        ->keyBy('player_id');

    $ineligibleAwayPlayers = Fine::whereIn('player_id', $awayPlayers->pluck('id'))
        ->where('match_day_ineligible', $matchDay)
        ->get()
        ->keyBy('player_id');

    // Example events array; you should replace it with your actual logic
    $events = [
        'home_goals' => 2,
        'away_goals' => 2,
        'home_red_cards' => 1,
        'away_red_cards' => 1,
    ];

    return view('fixtures.select_player', compact('fixture', 'homePlayers', 'awayPlayers', 'events', 'ineligibleHomePlayers', 'ineligibleAwayPlayers'));
}

    
    
    

    

}