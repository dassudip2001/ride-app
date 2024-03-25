<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function submit(Request $request)
    {
         //  login logic
        // validate phone number
        $request->validate([
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        // find or create user
        $user = User::firstOrCreate(['phone' => $request->phone]);
        if(!$user){
            return response()->json([
                'message' => 'User not process a user with this phone number'
            ], 401);
        }
//        dd($user);
        $user->notify(new \App\Notifications\LoginNeedVarification());
        // send otp
        // return response
        return response()->json([
            'message' => 'OTP sent to your phone number'
        ]);

    }
    public function verify(Request $request)
    {
        // validate the incoming request
        $request->validate([
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'login_code' => 'required|numeric|between:100000,999999'
        ]);

        // find user
        $user = User::where('phone', $request->phone)
            ->where('login_code', $request->login_code)
            ->first();
        if(!$user){
            return response()->json([
                'message' => 'User not process a user with this phone number'
            ], 401);
        }

        // check otp
        if($user->login_code != $request->login_code){
            return response()->json([
                'message' => 'Invalid OTP'
            ], 401);
        }
        // generate token
        $token = $user->createToken($request->login_code)->plainTextToken;
        // return response
        return response()->json([
            'token' => $token
        ]);
    }
}
