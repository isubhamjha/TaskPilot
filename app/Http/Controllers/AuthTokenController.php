<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthTokenRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthTokenController extends Controller
{
    /**
     * Issue a Sanctum personal access token after validating credentials.
     */
    public function store(AuthTokenRequest $request): JsonResponse
    {
        $data = $request->validated();

        $credentials = [
            filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name' => $data['login'],
            'password' => $data['password'],
        ];

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();

        $minutes = config('sanctum.expiration');
        $expiresAt = $minutes ? now()->addMinutes($minutes) : null;

        $token = $user
            ->createToken('api', ['*'], $expiresAt)
            ->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt?->toIso8601String(),
        ]);
    }
}
