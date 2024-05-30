<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Traits\ApiResponse;
use Carbon\Carbon;
class AuthenticationController extends Controller
{
    use ApiResponse;

    public function login(Request $request)
    {
        try {
            $credentials = [
                "username" => $request->username,
                "password" => $request->password
            ];

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                // Check if the user already has a valid token
                if ($existingToken = $user->tokens()->latest()->first()) {
                    // Check if the token is expired
                    // dd(Carbon::parse(now()->subMinutes(config('sanctum.expiration')))->format("F d Y"));
                    // dd($existingToken->created_at->lte(now()->subMinutes(config('sanctum.expiration'))));
                    if ($existingToken->created_at->lte(now()->subMinutes(config('sanctum.expiration')))) {
                        // Expired, delete the token
                        $existingToken->delete();

                        // Authenticate the user again to generate a new token
                        Auth::logout();
                        return $this->apiResponse(409, 'Token expired, please login again.');
                    }
                    // else {
                    //     // Update the created_at field to extend the expiration
                    //     $existingToken->created_at = now()->addMinutes(config('sanctum.expiration'));
                    //     $existingToken->save();

                    //     return $this->apiResponse(200, 'Token refreshed', null, $existingToken->plainTextToken);
                    // }
                }
                // dd($user->tokens()->latest()->first()->token);
                // If no existing token or token was deleted, create a new token
                // $token = $user->createToken('access-token')->plainTextToken;
                return $this->apiResponse(200, 'Access granted', null, ["token" => $user->tokens()->latest()->first()->token , "user" => $user]);
            }

            return $this->apiResponse(401, 'Invalid credentials');

        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->apiResponse(500, 'An error occurred', $th->getMessage());
        }
    }

    // public function login(Request $request)
    // {
    //     try {
    //             $credentials = [
    //                 "username" => $request->username,
    //                 "password" => $request->password
    //             ];

    //             if (Auth::attempt($credentials))
    //             {
    //                 $user = Auth::user();

    //                 // Check if user already has a valid token
    //                 if ($existingToken = $user->tokens()->latest()->first()) {
    //                     // Check if token is expired
    //                     if ($existingToken->created_at->lte(now()->subMinutes(config('sanctum.expiration')))) {
    //                         // Expired, delete the token
    //                         DB::table('personal_access_tokens')->where('id', $existingToken->id)->delete();
    //                         return $this->apiResponse(409, 'Access Denied');
    //                     }else{


    //                         // Update the expires_at field
    //                         $existingToken->created_at = Carbon::now()->addMinutes(config('sanctum.expiration'));
    //                         $existingToken->save();

    //                         return $this->apiResponse(409, 'Refresh Token',null,$existingToken);


    //                         return $this->apiResponse(409, 'Token Expired');
    //                     }
    //                 }
    //             }

    //         return $this->apiResponse(200, 'Access Granted', null, $existingToken->plainTextToken);
    //         // Create a new token should be handle by admin
    //         // $token = $user->createToken('access-token')->plainTextToken;
    //     } catch (\Throwable $th) {
    //     //    \Log::error($th);
    //          dd($th);
    //        return $this->apiResponse(409, $th);
    //     }
    // }

    public function logout (Request $request){

        $user = User::find($request->id);
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function registerUser()
    {
        // $token = $user->createToken('access-token')->plainTextToken;
    }

    public function refreshAccessToken(){}
    public function createAccessToken(){}
}
