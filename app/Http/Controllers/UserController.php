<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected function genToken($user, $email)
    {
        $plainTextToken = $user->createToken($email)->plainTextToken;
        $token = explode('|', $plainTextToken);
        return $token;
    }

    public function register(Request $request, User $user)
    {
        $this->authorize('storeUser', $user);
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:3',
            'role' => 'required'
        ]);
        return User::create([...$data, Hash::make($request->password)]);
    }

    public function login(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where(["email" => $request->email])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $user['token'] = $this->genToken($user, $user->email);
        return $user;

    }
}
