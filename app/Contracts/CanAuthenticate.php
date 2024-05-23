<?php

namespace App\Contracts;
use App\Models\User;


interface CanAuthenticate
{
    public function registerUser($payload);
    public function loginUser($payload);
    public function resetPassword($payload);
    public function createAccessToken(User $user, $token = 'App');
    public function refreshAccessToken();
    public function logoutUser($userId);
}
