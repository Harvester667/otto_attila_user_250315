<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\api\ResponseController;
use Illuminate\Support\Facades\Gate;

class UserController extends ResponseController {

    public function getUsers() {

        if ( !Gate::allows( "super" )) {

            return $this->sendError( "Autentikációs hiba.", "Nincs jogosultság.", 401 );
        }

        $users = User::all();
        return $this->sendResponse( $users, "Betöltve." );
    }

    public function setAdmin( Request $request ) {

        if ( !Gate::allows( "super" )) {

            return $this->sendError( "Autentikációs hiba.", "Nincs jogosultság.", 401 );
        }

        $user = User::find( $request[ "id" ]);
        $user->admin = 1;

        $user->update();

        return $this->sendResponse( $user->name, "Admin jog megadva." );
    }

    public function updateUser( Request $request ) {

        if( !Gate::allows( "super" )) {

            return $this->sendError( "Autentikációs hiba.", "Nincs jogosultság.", 401 );
        }

        $user = User::find( $request[ "id" ]);

        if($user){
        $user->name = $request[ "name" ];
        $user->email = $request[ "email" ];
        $user->update();

        return $this->sendResponse( $user, "Felhasználó frissítve" );
        }else{
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function destroyUser( Request $request ) {

        if( !Gate::allows( "super" )) {

            return $this->sendError( "Autentikációs hiba.", "Nincs jogosultság.", 401 );
        }

        $user =  User::find( $request[ "id" ]);
        $user->delete();

        return $this->sendResponse( $user->name, "Felhasználó törölve." );
    }
}