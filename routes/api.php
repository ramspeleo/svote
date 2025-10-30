<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\BallotOptionController;
use App\Http\Controllers\VoteController;
use App\Models\Election;

Route::get('/elections', function () {
    return Election::with('ballotOptions')->get();
});


Route::apiResource('votes', VoteController::class);
Route::get('/elections/{election}/results', [App\Http\Controllers\ElectionController::class, 'results']);

Route::middleware('api')->group(function () {
    Route::apiResource('elections', ElectionController::class);
    Route::apiResource('ballot-options', BallotOptionController::class);
});

// Quick test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});
