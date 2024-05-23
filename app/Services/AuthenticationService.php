<?php
namespace App\Services;
use App\Models\User;
use Auth;
use Laravel\Sanctum\HasApiTokens;


// Contracts implement
use App\Contracts\CanAuthenticate;


class AuthenticationService implements CanAuthenticate
{

    use HasApiTokens;

    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function registerUser($payload)
    {
        $this->model->create();
        //create user
        //create access token for user

    }

    public function loginUser($payload) {
        if(Auth::attempt(['username'=> $payload['username'] , 'password' => $payload['password']]))
        {
            return 'redirect to home';
        }
        return 'invalid credentials';
    }
    public function resetPassword() {}
    public function createAccessToken(User $user, $token = 'App') {
        // Personal | App Token
        // createToken @name @abilities @expiration
        $token = $request->user()->createToken($token,['*'], now()->addYear(1));

        return ['token' => $token->plainTextToken];
    }
    public function refreshAccessToken() {}
    public function logoutUser($userId) {
        return Auth::logoutUser($userId);
    }

}
