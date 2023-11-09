<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller {
    public function register(Request $request) {
        $data = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

            return response()->json($user, 201);
    }

    // public function login(Request $request) {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string',
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         $token = $user->createToken('Personal Access Token')->accessToken;

    //         return response()->json(['user' => $user, 'access_token' => $token], 200);
    //     } else {
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }
    // }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Incorrect username or password'], 401);
        }
    
        return $this->respondWithToken($token);
    }
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 24,
        ]);
    }

    public function validateCredentials(Request $request){
        $credentials = $request->only(['username', 'email']);
        $email = $credentials['email']; // Get the email from the credentials

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Email is valid
            $user = User::where('email', $email)->first();

            if ($user) {
                // User with a matching email was found
                if ($credentials['username'] === $user->username) {
                    // Username matches too
                    return response()->json(['message' => 'Credentials are correct'], 200);
                } else {
                    return response()->json(['message' => 'Incorrect username'], 404);
                }
            } else {
                return response()->json(['message' => 'User not found or incorrect email'], 404);
            }
        } else {
            // Invalid email format
            return response()->json(['message' => 'Invalid email format', 'user' => null], 404);
        }
    }


    public function forgotPassword(Request $request) {
        $request->only(['email', 'username']);
    
        $isExist = User::where('username', $request->username)->where('email', $request->email)->first();
    
        if($isExist){
            return response()->json(['message'=> 'user exists'], 200);
            $this->respondWithToken($token);
        }else{
            return response()->json(['message'=> 'user not found'], 404);
        }
        }
    
        public function changePassword(Request $request, $id){
        $new_password = $request->only('new_password');
        
        $user = User::find($id);
     
        $user->password = bcrypt($new_password);
        
        $user->save();
        return $response()->json(['message'=>'password successfully changed'], 200);
        }

    public function logout() {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'User logged out successfully']);

    }

    public function getUserInfo() {
        $user = Auth::user();
        return response()->json($user, 200);
    }
}
