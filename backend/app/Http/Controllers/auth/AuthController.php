<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Usuário registrado com sucesso.',
            'token' => $token,
        ], 201);
    }

    /**
     * Login a user and return a JWT token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }


    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function me()
    {
        try {
            $user = JWTAuth::user();
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not get user'], 500);
        }
    }
}
