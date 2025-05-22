<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;


Route::post('/new_task', [TaskController::class, 'store']);
Route::put('/update_task/{id}', [TaskController::class, 'update']);

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});
