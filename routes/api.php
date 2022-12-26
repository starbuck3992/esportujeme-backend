<?php

use App\Http\Controllers\TournamentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TournamentMatchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

//Public
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/authorize/{provider}/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/authorize/{provider}/login', [SocialAuthController::class, 'login']);

Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/tournaments/{slug}', [TournamentController::class, 'showTournament']);

//User
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/users/settings', [UserController::class, 'show']);
    Route::post('/users/settings', [UserController::class, 'update']);
    Route::get('/users/providers', [ProviderController::class, 'list']);

    Route::post('/images', [ImageController::class, 'store']);

    Route::post('/tournaments/{slug}/register', [TournamentController::class, 'registerParticipant']);
    Route::post('/tournaments/{slug}/matches', [TournamentMatchController::class, 'saveScore']);

    Route::post('/logout', [AuthController::class, 'logout']);
});

//Admin
Route::group(['prefix' => 'admin','middleware' => ['auth:sanctum']], function () {
    Route::get('/tournaments/formData', [TournamentController::class, 'getCreateFormData']);
    Route::post('/tournaments', [TournamentController::class, 'createTournament']);
    Route::get('/tournaments/{slug}/matches', [TournamentMatchController::class, 'list']);
});
