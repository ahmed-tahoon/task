<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::create(array_merge(
            $validatedData,
            ['password' => Hash::make($validatedData['password'])]
        ));

        return response()->json([
            'user' => $user->refresh(),
        ], 201);
    } 

    public function login(Request $request)
 {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');


    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => __('auth.failed')], 401);
    }

    $user = Auth::user();
    $token = Auth::guard('sanctum')->user()->createToken('login')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
}
    
}
