<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\TestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware( "auth:sanctum" )->group( function(){

    Route::post( "/logout", [ AuthController::class, "logout" ]);
    Route::get( "/getusers", [ UserController::class, "getUsers" ]);
    Route::put( "/setadmin/{id}", [ UserController::class, "setAdmin" ]);
//    Route::put( "updateuser", [ AuthController::class, "updateUser" ]);
//    Route::delete( "/deleteuser", [ AuthController::class, "destroyUser" ]);
    Route::get("/isadmin", [ TestController::class,"isAdmin" ]);
});

Route::post( "/register", [ AuthController::class,"register" ]);
Route::post( "/login", [ AuthController::class,"login" ]);
