<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/authorize/{provider}/redirect', [SocialAuthController::class, 'redirect']);
Route::get('/authorize/{provider}/login', [SocialAuthController::class, 'login']);

Route::get('/email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/users/settings', [UserController::class, 'show']);
    Route::post('/users/settings', [UserController::class, 'update']);
    Route::get('/users/providers', [ProviderController::class, 'list']);
    Route::post('/images', [ImageController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
