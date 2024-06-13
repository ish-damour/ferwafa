<?php

namespace App\Http\Controllers;

use App\Models\Team;
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
            if ($matchDateTime->lessThanOrEqualTo(Carbon::now()) && $fixture->status != 'started') {
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
    

    public function generateFixtures()
    {
        $teams = Team::all()->shuffle(); // Shuffle teams randomly
        $teamCount = $teams->count();
    
        if ($teamCount < 2) {
            return back()->with('error', 'Not enough teams to generate fixtures');
        }
    
        $fixtures = [];
        $matchesPerDay = 4; // Maximum of 4 matches per day
        $matchTimes = ['14:00', '16:00', '18:00'];
        $startDate = Carbon::create(2024, 6, 8); // Start from June 8, 2024
        $currentMatchDayDate = $startDate->copy();
        $matchDayInterval = 7; // 1 week interval
    
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
    
        DB::table('fixtures')->insert($fixtures);
    
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
    
        public function storeResult(Request $request, $id)
        {
            $request->validate([
                'home_team_goals' => 'required|integer',
                'away_team_goals' => 'required|integer',
            ]);
    
            $fixture = Fixture::findOrFail($id);
            $homeTeam = $fixture->homeTeam;
            $awayTeam = $fixture->awayTeam;
    
            // Update fixture with the result
            $fixture->home_team_goals = $request->home_team_goals;
            $fixture->away_team_goals = $request->away_team_goals;
            $fixture->result = $request->home_team_goals . '-' . $request->away_team_goals;
            $fixture->save();
    
            // Update team statistics
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
    
            return redirect()->route('fixtures.index')->with('success', 'Result added and teams updated successfully');
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
}