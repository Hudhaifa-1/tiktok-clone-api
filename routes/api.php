<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group( function () {
   Route::get('/logged-in-user', [UserController::class,'loggedInUser']);
});
