<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Mockery\Exception;

class UserController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }


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
            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token);
        } catch (Exception $e){
            return response()->json(['status' => 'error', 'report' => "Unhandled exception. L'errore è stato riportato"],500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
