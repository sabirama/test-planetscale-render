<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email|email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            "username" => $fields["username"],
            "email" => $fields["email"],
            "password" => bcrypt($fields["password"]),
        ]);

        $token = $user->createToken("userAuth")->plainTextToken;

         return response([
            "user" => $user,
            "token" => $token
        ], 201);
}


    //log-in function
    public function login(Request $request)  {
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $fields['username'])->first();

        if ($user) {

            if(!Hash::check($fields['password'], $user->password)) {
                return response (["Wrong Password"],401);
            }

            $token = $user->createToken('userAuth')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token
        ], 201);

        }

        return response("Username does not exist");

        }


    public function logout(Request $request){
        auth()->User()->tokens()->delete();

          return response([
            'message'=>'logged out'
          ]);
    }
}
