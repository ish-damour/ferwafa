<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 20); // Default to 20 if not provided
    
        // Fetch players ordered by id in descending order
        $players = Player::with('team')
                        ->orderBy('id', 'desc')
                        ->paginate($perPage);
    
        return view('players.index', compact('players', 'perPage'));
    }
    
    

    public function create()
    {
        $teams = Team::all();
        return view('players.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'team_id' => 'required|exists:teams,id',
        ]);

        Player::create($request->all());

        return redirect()->route('players.index')->with('success', 'Player added successfully');
    }

    public function edit(Player $player)
    {
        $teams = Team::all();
        return view('players.edit', compact('player', 'teams'));
    }

    public function update(Request $request, Player $player)
    {
        $request->validate([
            'name' => 'required',
            'team_id' => 'required|exists:teams,id',
        ]);
    
        $player->update($request->all());
    
        return redirect()->route('players.index')->with('success', 'Player updated successfully');
    }

    public function topScorers()
{
    $topScorers = Player::where('goals', '>', 0)
        ->orderBy('goals', 'desc')
        ->with('team')
        ->get();

    return view('players.top_scorers', compact('topScorers'));
}
    

    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->route('players.index')->with('success', 'Player deleted successfully');
    }

    
}
