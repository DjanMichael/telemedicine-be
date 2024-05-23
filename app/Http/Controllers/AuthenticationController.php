<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class AuthenticationController extends Controller
{

    public function login(Request $request)
    {
        try {
            $credentials = [
                "username" => $request->username,
                "password" => $request->password
            ];
            if(Auth::attempt($credentials))
            {
                return response()->json(['message'=> 'Access Granted']);
            }

        } catch (\Throwable $th) {
           \Log::error($th);
        }
        return response()->json(['message'=> 'Invalid Credentials'], 409);

    }

    public function registerUser()
    {

    }

    public function refreshAccessToken(){}
    public function createAccessToken(){}
}
