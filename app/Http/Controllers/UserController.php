<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UserController extends Controller
{
    public function login(Request $request) {

        $validatedData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($validatedData)) {
            return response()->json(['message' => 'invalid login data'],401);
        }


        return Auth::user()-> createToken('authToken')->accessToken;
    }

    public function register(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        $token = $user -> createToken('authToken')->accessToken;

        return [
            'user' =>$validatedData,
            'token' => $token
        ];

    }

    public function passwordUpdate(Request $request) {
            $user = Auth::user();
            $validatedData = $request -> validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed',
                'new_password_confirmation' => 'required',
            ]);

            if(!Hash::check($validatedData['old_password'],$user->password)) {
                return response()->json(['message' => 'old password invalid'],401);
            }

           $user -> password =  bcrypt($request -> new_password);

            if($user -> save()) {
                return response()->json(['message' => 'password updated Successfully'],200);

            }

            return response()->json(['message' => 'some error happened'],500);

    }

    public function profileUpdate(Request $request) {
        $user = Auth::user();

        $validatedData = $request -> validate([
            'name' => 'required',
            'email' => [
                'email',
                Rule::unique('users')->ignore(Auth::id())
            ],
        ]);


       if($user -> update($validatedData)) {
           return response()->json(['message' => 'profile updated Successfully'],200);

       }

        return response()->json(['message' => 'some error happened'],500);

    }
}
