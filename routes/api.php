<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/update-user-image', [UserController::class,'updateUserImage']);

Route::middleware(['auth:sanctum'])->group( function () {
   Route::get('/logged-in-user', [UserController::class,'loggedInUser']);
});
