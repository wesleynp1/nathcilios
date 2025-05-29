<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'token' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()]
            ]);

            // Here we will attempt to reset the user's password. If it is successful we
            // will update the password on an actual user model and persist it to the
            // database. Otherwise we will parse the error and return the response.
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($request->string('password')),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status != Password::PASSWORD_RESET) {
                throw ValidationException::withMessages([
                    'email' => [__($status)],
                ]);
            }

            return redirect("login")->with("message","Senha trocada com sucesso!");;
        }catch(Exception $e){
            return back()->with("message","Erro ao trocar a senha:".$e->getMessage());
        }
    }

    public function update(Request $request){
        try{
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', Rules\Password::defaults(), 'confirmed'],
            ]);

            $request->user()->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect("/")->with("message","Senha atualizada com sucesso!");
        }catch(Exception $e){
            return back()->with("error","Erro ao alterar a senha: ".$e->getMessage());
        }
    }
}
