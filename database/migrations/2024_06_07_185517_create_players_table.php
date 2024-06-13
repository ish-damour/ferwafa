<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
// create_players_table migration
Schema::create('players', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('team_id')->constrained();
    $table->integer('goals')->default(0);
    $table->integer('assists')->default(0);
    $table->integer('yellow_cards')->default(0);
    $table->integer('red_cards')->default(0);
    $table->integer('matches_missed')->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
