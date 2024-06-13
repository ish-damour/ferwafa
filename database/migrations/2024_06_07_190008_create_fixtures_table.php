<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->integer('match_day');
            $table->foreignId('home_team_id')->constrained('teams');
            $table->foreignId('away_team_id')->constrained('teams');
            $table->integer('home_team_goals')->default(0);
            $table->integer('away_team_goals')->default(0);
            $table->string('result')->nullable();
            $table->date('match_date'); // Date only
            $table->time('starting_time'); // Time only
            $table->timestamps();
            $table->string('status')->default('scheduled'); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
