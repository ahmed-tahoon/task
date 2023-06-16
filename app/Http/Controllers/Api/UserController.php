<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterUserRequest;

class UserController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();
    
        $birthdate = $validatedData['birthdate'];
        $minAge = 18;
        $diff = $birthdate->diffInYears(now());
    
        if ($diff < $minAge) {
            return response()->json(['error' => __('validation.birthdate.before')], 422);
        }
    
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'birthdate' => $validatedData['birthdate'],
        ]);
    
        $token = $user->createToken('registration')->plainTextToken;
    
        return response()->json([
            'user' => $user->refresh(),
            'token' => $token,
        ], 201);
    }
    

    
}
