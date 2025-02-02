<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "name" => ["required","min:2"],
            "email" => ["required" ,"email", "unique:users,email"],
            "password" => ["required" ,"min:6"]
        ]);

        if ($validated) {
            $validated["password"] = Hash::make($validated["password"]);
        }

        $user = User::query()->create($validated);
        $token = $user->createToken("main");

        return response()->json([
            "user" => $user,
            "token" => $token->plainTextToken
        ], 201);
    }

    public function Login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "email" => ["required" ,"email", "exists:users,email"],
            "password" => ["required"]
        ]);

        if (!Auth::attempt($validated)) {
            throw new HttpResponseException(response([
                "message" => "username or password wrong"
            ], 401));
        }

        $user = User::query()->firstWhere("email", $validated["email"]);
        $token = $user->createToken("main");

        return response()->json([
            "user" => $user,
            "token" => $token->plainTextToken
        ], 201);
    }
}
