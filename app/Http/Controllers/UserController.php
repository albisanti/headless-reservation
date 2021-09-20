<?php

namespace App\Http\Controllers;

use App\Models\User;
use Mockery\Exception;

class UserController extends Controller
{
    public function Register(\Illuminate\Http\Request  $request){
        $this->validate($request,[
           'email' => 'required|email',
           'pwd' => 'required',
           'name' => 'required'
        ]);
        try {
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => $request->pwd
            ]);
            if($user) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => "C'è stato un problema nella creazione del nuovo utente. Riprovare o contattare il servizio di assistenza"],500);
        } catch (Exception $e){
            return response()->json(['status' => 'error', 'report' => "Unhandled exception. L'errore è stato riportato"],500);
        }
    }

    public function Login(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'pwd' => 'required'
        ]);
        try {
            $user = User::where('email',$request->email)->first();
            if($user) return response()->json(['status' => 'success','data' => $user]);
            return response()->json(['status' => 'error', 'report' => "L'email/password non coincidono con alcun utente. Prova ad inserire una combinazione email/password corretta"],401);
        } catch (Exception $e){
            return response()->json(['status' => 'error', 'report' => "Unhandled exception. L'errore è stato riportato"],500);
        }
    }

}
