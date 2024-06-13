<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// PlayerStat.php
class PlayerStat extends Model {
    public function player() {
        return $this->belongsTo(Player::class);
    }

    public function fixture() {
        return $this->belongsTo(Fixture::class);
    }
}