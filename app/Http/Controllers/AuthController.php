<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function signup(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required'
        ]);
        $user = new User;
        $user->email = $request->email;
        $user->password = app('hash')->make($request->password);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->confirm_token = Hash::make(date('d-m-Y').'asd'.$request->name.$request->surname);
        if($user->save()) return response()->json(['status' => 'success']);
        return response()->json(['status' => 'error','report' => 'Non è stato possibile registrare il nuovo utente']);
    }

    public function login(\Illuminate\Http\Request $request){

        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
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
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
