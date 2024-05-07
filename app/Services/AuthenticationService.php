<?php
namespace App\Services;
use App\Models\User;
use Auth;
class AuthenticationService
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function registerUser($payload)
    {
        $this->model->create();
    }
    public function loginUser() {}
    public function resetPassword() {}
    public function refreshAccessToken() {}
    public function logoutUser($userId) {
        return Auth::logoutUser($userId);
    }

}
