<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Player;
use App\Models\Fixture;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function store(Request $request)
    {
        $player = Player::find($request->player_id);
        $fixture = Fixture::find($request->fixture_id);

        $fine = Fine::create([
            'player_id' => $request->player_id,
            'match_day_ineligible' => $fixture->match_day + 1,
            'reason' => $request->reason,
        ]);

        $player->increment('red_cards');

        return redirect()->route('fixtures.index')->with('success', 'Player fined successfully!');
    }
}
