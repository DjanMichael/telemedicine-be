<?php

namespace App\Traits;

trait ApiResponse
{
    public function apiResponse($status, $message, $errCode = null, $token = null)
    {

        if($token != null)
        {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'token' => $token,
            ]);
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'errCode' => $errCode
        ]);
    }
}
