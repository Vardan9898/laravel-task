<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|unique:users',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required|date',
        ]);

        $user = new User();
        $user->login = $request->input('login');
        $user->password = Hash::make($request->input('password'));
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->birth_date = $request->input('birth_date');
        $user->save();

        return response()->json(['message' => 'User registered successfully']);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['login', 'password']);

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Invalid login or password'], 401);
    }
}
