<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User; 

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        
        $email = $request->email;
        $password = $request->password;

        
        $user = User::where('email', $email)->first();

        if (!$user) {
            
            throw ValidationException::withMessages([
                'email' => ['The provided email is incorrect.'],
            ]);
        }

        
        if (!Hash::check($password, $user->password)) {
            
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
        }

        
        if (Auth::attempt(['email' => $email, 'password' => $password], $request->remember)) {
            $user = Auth::user();

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type,
                ]
            ]);
        }

        
        throw ValidationException::withMessages([
            'email' => ['Login failed. Please try again.'],
        ]);
    }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
