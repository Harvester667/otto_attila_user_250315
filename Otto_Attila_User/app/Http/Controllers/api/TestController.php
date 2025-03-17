<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class TestController extends Controller
{
    public function isAdmin()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Nem vagy bejelentkezve.'], 401);
        }

        if ($user->admin === 1) {
            return response()->json(['message' => 'Engedély megadva.']);
        }

        if ($user->admin === 2) {
            return response()->json(['message' => 'Engedély megadva.']);
        }

        return response()->json(['message' => 'Nincs jogosultság.'], 403);
    }
}