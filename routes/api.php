<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/index', [TaskController::class, 'index']);
Route::post('/new_task', [TaskController::class, 'store']);
Route::put('/update_task/{id}', [TaskController::class, 'update']);
Route::delete('/delete_task/{id}', [TaskController::class, 'destroy']);


Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});
