<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use App\ShabuNooNee\DiningTable;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', "loginByQrCode"]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
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
        //return hash_hmac('sha256', "EAADs9Pa2orYBAJWkcpHyNcSF7ZBDkZAyWZCB79ZA3ZCLe4rNCMnNoMvngx7EVrv97y8ZANHIyg7g44sba4g4r2MelePr7dVY6U7tCZAbv2SRyedMvOWZAXzJbpZAlOlsMikwLnG8opZCcT27jusUXfEyz8xNdmahZClBO7shlBZAHkYePMMZBpMZADiFOZALSHzF4GVtMs24oZCgftx35gZDZD", "45bf99a1675babbadc7033159fed9ee4"); 

        if (Auth::check()) {
            return response()->json(auth()->user());
        } else {
            abort(403, "ไม่มีสิทธิ์เข้าถึง");
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
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function testLogout()
    {
        Auth::logout();
        return "logOut Success";
    }

    public function loginByQrCode()
    {
        
        $user = DiningTable::where("checkAuth", request("uuid"))
            ->whereIn("status_id",[1,2])
            //->whereDate("created_at", \Carbon\Carbon::now())
            ->select("user_id")
            ->with("userProfile")
            ->first();

        if(!$user){
            return response()->json([],201);
        }

        $credentials = ["id" => $user->user_id, "password" => $user->userProfile->pw];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
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
            'expires_in' => Auth::factory()->getTTL()
        ]);
    }
}
