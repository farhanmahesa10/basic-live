<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    //
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();

        if(!$user){
            return response()->json([
                'status' => 'failed',
                'message' => "Email atau password salah"
            ]);
           
        }else{
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('user-token')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'user' => $user,
                    'token' => $token
                ]);
            }else{
                return response()->json([
                    'status' => 'failed',
                    'message' => "Email atau password salah"
                ]);
            }
        }
       
    }
    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('user-token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token
        ]);
        
       
    }

    public function logout(Request $request){
        $user = $request->user();
        // return response()->json($user);
        $user->tokens()->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function isauthenticated(Request $request){
        return response()->json([
            'status' => 'success',
        ]);
    }
}