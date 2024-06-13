<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authmanager;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\FixturesController;
use App\Http\Controllers\PlayerController;

// Authentication Routes
Route::get('/login', [Authmanager::class, 'login'])->name('login');
Route::post('/login', [Authmanager::class, 'loginPost'])->name('login.post');
Route::get('/registration', [Authmanager::class, 'registration'])->name('registration');
Route::post('/registration', [Authmanager::class, 'registrationPost'])->name('registration.post');
Route::get('/logout', [Authmanager::class, 'logout'])->name('logout');

// Home Route
Route::get('/home', function () {
    return view('welcome'); // Replace with your actual home view
})->name('home');

// Team Routes
Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
Route::resource('teams', TeamController::class)->except(['create', 'store']);

// Fixture Routes
Route::get('fixtures/generate', [FixturesController::class, 'generateFixtures'])->name('fixtures.generate');
Route::get('fixtures/live', [FixturesController::class, 'live'])->name('fixtures.live');
Route::get('fixtures/{id}/addResult', [FixturesController::class, 'addResult'])->name('fixtures.addResult');
Route::post('/fixtures/{fixture}/storeResult', [FixturesController::class, 'storeResult'])->name('fixtures.storeResult');
Route::get('/fixtures/endMatch/{id}', [FixturesController::class, 'endMatch'])->name('fixtures.endMatch');
Route::post('/fixtures/updateLive/{id}', [FixturesController::class, 'updateLive'])->name('fixtures.updateLive');
Route::resource('fixtures', FixturesController::class)->except(['show', 'create', 'store']);

// Player Routes
Route::resource('players', PlayerController::class);
Route::get('/api/teams/{team}/players', [TeamController::class, 'getPlayers']);
Route::get('/fixtures/{fixture}/stats_form', [FixturesController::class, 'statsForm'])->name('fixtures.statsForm');
Route::get('/fixtures/day/{day}', [FixturesController::class, 'indexByDay'])->name('fixtures.byDay');

Route::post('/fixtures/{fixture}/storePlayerStats', [FixturesController::class, 'storePlayerStats'])->name('fixtures.storePlayerStats');



