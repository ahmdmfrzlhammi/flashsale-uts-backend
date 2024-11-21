<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Membuat user baru
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // Membuat token untuk user baru
    $token = $user->createToken('YourAppName')->plainTextToken;

    // Mengembalikan respons dengan token
    return response()->json([
        'message' => 'User created successfully',
        'user' => $user,
        'token' => $token,  // Mengembalikan token ke frontend
    ], 201);
}
    

    // Login
    public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Cek apakah email dan password cocok
    $user = User::where('email', $request->email)->first();

    if ($user && Hash::check($request->password, $user->password)) {
        // Membuat token jika login berhasil
        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'token' => $token
        ], 200);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
