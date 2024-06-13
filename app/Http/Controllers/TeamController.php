<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
        ]);

        Team::create([
            'name' => $request->name,
            'played_matches' => 0,
            'goals_scored' => 0,
            'goals_conceded' => 0,
            'goal_difference' => 0,
            'points' => 0,
            'standing' => 0,
        ]);

        return redirect()->route('teams.index')->with('success', 'Team created successfully');
    }

    public function index()
    {
        $teams = Team::orderBy('points', 'desc')
            ->orderBy('goal_difference', 'desc')
            ->orderBy('goals_scored', 'desc')
            ->get();

        return view('teams.index', compact('teams'));
    }

    public function edit(Team $team)
    {
        return view('teams.edit', compact('team'));
    }

    

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
        ]);

        $team->update([
            'name' => $request->name,
        ]);

        return redirect()->route('teams.index')->with('success', 'Team updated successfully');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Team deleted successfully');
    }

}
