<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        // $token = $user->createToken('olnx_token')->plainTextToken;

        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];

        //event(new Registered($user));

        return response($user, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check Email
        $user = User::where('email', $fields['email'])->first();

        // Check Password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }

        

        $user->tokens()->delete();
        $token = $user->createToken('olnx_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        // $tokensss = $request->bearerToken();

        // return $tokensss;

        // auth()->setUser($user);

        //log the user in
        // Auth::login($user);

        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        //     // Authentication was successful...
        //     return redirect()->intended('dashboard');
        // } else {
        //     // Authentication failed...
        //     return redirect()->back()->withErrors([
        //         'email' => 'The provided credentials do not match our records.',
        //     ]);
        // }

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
