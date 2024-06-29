<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'team_id', 'goals', 'assists', 'yellow_cards', 'red_cards', 'matches_missed'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }
}
