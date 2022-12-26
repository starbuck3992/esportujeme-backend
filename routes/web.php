<?php


use Illuminate\Support\Facades\Route;

Route::get('/notification', function () {
    $tournamentMatch = \App\Models\TournamentMatch::find(1);

    return (new \App\Notifications\TournamentScoreRejection($tournamentMatch))
        ->toMail($tournamentMatch);
});
