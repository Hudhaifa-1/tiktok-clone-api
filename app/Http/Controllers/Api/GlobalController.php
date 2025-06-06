<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersCollection;
use App\Models\User;

class GlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getRandomUsers()
    {
        try {
            // $user = auth()->user();
            // $suggested = [];
            // $following = [];
            // if($user){
            //     $suggested = User::where('id', '!=', $user->id)->inRandomOrder()->limit(5)->get();
            //     $following = User::where('id', '!=', $user->id)->inRandomOrder()->limit(10)->get();
            // }else{
                $suggested = User::inRandomOrder()->limit(5)->get();
                $following = User::inRandomOrder()->limit(10)->get();
            // }

            return response()->json([
                'suggested' => new UsersCollection($suggested),
                'following' => new UsersCollection($following),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
