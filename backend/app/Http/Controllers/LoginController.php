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
        $user = User::firstOrCreate(
            [
                'phone' => $request->phone
            ]
        );
        if(!$user){
            return response()->json([
                'message' => 'User not process a user with this phone number'
            ], 401);
        }
        $user->notify(new \App\Notifications\LoginNeedVarification());
        // send otp
        // return response
        return response()->json([
            'message' => 'OTP sent to your phone number'
        ]);

    }
}
