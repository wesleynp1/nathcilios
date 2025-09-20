<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class GuestController
{    
    static function guestUser(Request $r){
        $r->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number'=>['string', 'max:11'],                
        ]);


            return User::createOrFirst([
            'name'        => $r->name,
            'phone_number'=> $r->phone_number,
            'email'       => $r->phone_number."@nathcilios.free.nf",
            'password'    => env("GUEST_PASSWORD"),
            'is_guest'    => true
            ]);

            //return User:: firstOrCreate("email",($r->phone_number."@nathcilios.free.nf"))->first();

            //return $user=DB::select("select * from users where email=?",[$r->phone_number."@nathcilios.free.nf"])[0];
        
    }    
}
