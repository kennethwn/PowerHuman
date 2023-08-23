<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller {
    private UserService $service;

    public function __construct(UserService $userService) {
        $this->service = $userService;
    }

    public function login(Request $request) {
        try {
            // validate request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Find user by email
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error(null, 401, 'failed', 'Unauthorized');
            }

            $user = $this->service->findUserByEmail($request->email);
            if (!Hash::check($request->password, $user->password)) {
                return new Exception('Credential not found!');
            }

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Login Succeed');
        }
        catch(Exception $e) {
            return ResponseFormatter::error(null, 400, 'failed', $e->getMessage());
        }
    }

    public function register(Request $request) {
        try {
            // Validate request
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password]
            ]);

            // Create user
            $user = $this->service->createUser(
                $request->name,
                $request->email,
                $request->password
            );

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_time' => 'Bearer',
                'user' => $user
            ], 'Register Succeed');
        }
        catch (Exception $e) {
            return ResponseFormatter::error(null, 400, 'failed', $e->getMessage());
        }
    }

    public function logout(Request $request) {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Logout Succeed');
    }

    public function fetch(Request $request) {
        $user = $request->user();
        return ResponseFormatter::success($user, 'Fetch Succeed');
    }
}
