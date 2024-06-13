<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('home_fixtures_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fixture_id')->constrained('fixtures');
            $table->foreignId('team_id')->constrained('teams');
            $table->integer('shots')->default(0);
            $table->integer('shots_on_target')->default(0);
            $table->integer('possession')->default(0);
            $table->integer('passes')->default(0);
            $table->integer('pass_accuracy')->default(0);
            $table->integer('fouls')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('red_cards')->default(0);
            $table->integer('offsides')->default(0);
            $table->integer('corners')->default(0);
            $table->integer('goals')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('home_fixtures_stats');
    }
};
