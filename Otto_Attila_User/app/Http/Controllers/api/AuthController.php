<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends ResponseController {

    public function register( UserRegisterRequest $request ) {

        $request->validated();

        $isFirstUser = User::count() === 0;
        $adminLevel = $isFirstUser ? 2 : 0;

        $user = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "password" => bcrypt( $request["password"]),
            "admin" => $adminLevel
        ]);

        return $this->sendResponse( $user->name, "Sikeres regisztráció.");
    }

    public function login( UserLoginRequest $request ) {

        $request->validated();

        if( Auth::attempt([ "email" => $request["email"], "password" => $request["password"]])) {

            $authUser = Auth::user();
            $token = $authUser->createToken($authUser->email . "Token")->plainTextToken;
            $data = [
                "user" => $authUser->email,
                "admin" => $authUser->admin,
                "token" => $token
            ];

            return $this->sendResponse($data, "Sikeres bejelentkezés.");
        } else {
            return $this->sendError("Autentikációs hiba.", "Hibás felhasználónév vagy jelszó.", 401);
        }
    }

    public function logout() {
        auth( "sanctum" )->user()->currentAccessToken()->delete();
        $name = auth( "sanctum" )->user()->name;

        return $this->sendResponse($name, "Sikeres kijelentkezés.");
    }

    public function getTokens() {
        $tokens = DB::table("personal_access_tokens")->get();
        return $tokens;
    }
}
