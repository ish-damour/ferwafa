<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeFixtureStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'team_id',
        'shots',
        'shots_on_target',
        'possession',
        'passes',
        'pass_accuracy',
        'fouls',
        'yellow_cards',
        'red_cards',
        'offsides',
        'corners',
        'goals',
    ];
}
