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
            'name' => ['required', 'string', 'max:255','required'],
            'phone_number'=>['string', 'max:11','required'],                
        ]);
        try{
            return User::where("email",$r->phone_number."@nathcilios.free.nf")->first()->id;
        }catch(Exception $e){
            $user = User::create([
                'name'        => $r->name,
                'phone_number'=> $r->phone_number,
                'email'       => $r->phone_number."@nathcilios.free.nf",
                'password'    => env("GUEST_PASSWORD"),
                'is_guest'    => true
                ]);
            return $user->id;
        }
    }    
}
