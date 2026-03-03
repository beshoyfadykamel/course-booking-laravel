<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use App\Traits\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {

        $user = $request->validated();
        $user['password'] = Hash::make($user['password']);

        $user = User::create($user);

        $token = $user->createToken($user->name);
        $token->accessToken->update([
            'expires_at' => now()->addDays(30),
        ]);


        $data = [
            'user' => new UserResource($user),
            'token' => $token->plainTextToken,
        ];

        return $this->success($data, 'User registered successfully', 201);
    }
}
