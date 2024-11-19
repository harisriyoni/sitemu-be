<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (!$token = JWTAuth::attempt($data)) {
            throw new HttpResponseException(response([
                'errors' => 'Username or Password Wrong!',
            ], 400));
        }
        return response()->json([
            'user' => new UserResource(Auth::user()),
            'token' => $token,
        ]);
    }
}
