<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'fixture_id',
        'match_day_ineligible',
        'reason',
        'minute',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }
}
