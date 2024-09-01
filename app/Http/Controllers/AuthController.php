<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Generate and return an API token for the authenticated user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generateToken(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = Auth::user()->createToken('API')->plainTextToken;

        return response()->json(['token' => 'Bearer ' . $token]);
    }
}

