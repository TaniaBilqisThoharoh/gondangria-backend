<?php

// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\NotifMail;
use Illuminate\Support\Carbon;


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
            // 'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'expires_in' => 60 * 60 * 24,
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
    
        $isExist = User::where('email', $request->email)->first();
        
        if($isExist){
            $token = rand(100000, 999999);
            $mailData = [
                'nama' => 'Hallo '. $isExist->username,
                'token' => $token
            ];
             
            Mail::to($request->email)->send(new NotifMail($mailData));
           
            $data = DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token
            ]);
            
            return response()->json(['message'=> 'Email telah terkirim, mohon periksa email dan folder spam anda'], 200);
            
        }else{
            
            return response()->json(['message'=> 'Mohon maaf email ini tidak terdaftar'], 404);
        }
    }

    // dalam isi requestnya ada email sama token
    public function validasi_password(Request $request){
            
        $isValid = DB::table('password_reset_tokens')
            ->where([
                ['email', $request->email],
                ['token', $request->token]
            ])
            ->orderBy('id', 'desc')
            ->first();
        
        if($isValid->created_at > Carbon::now()->addHour()) {
            return response()->json(['message'=>'Token expired'], 401);
        }
        
        if($isValid){
            return response()->json(['message'=>'Token valid'], 200);
        } else {
            return response()->json(['message'=>'Token tidak valid'], 401);
        }        
    }
    
    public function changePassword(Request $request){
            
        $pass = $request->input('password');
        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($pass);
        $user->save();
    
        return response()->json(['message'=>'Password berhasil diubah'], 200);
        
    }

    public function logout() {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'User berhasil log out']);

    }

    public function getUserInfo() {
        $user = Auth::user();
        return response()->json($user, 200);
    }
}
