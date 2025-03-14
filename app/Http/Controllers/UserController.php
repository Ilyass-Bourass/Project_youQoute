<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller


{
    public function register(Request $request)
    {
        //dd($request->all());
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3|string',
            'email'=>'required|email',
            'password'=>'required|min:6|confirmed'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message'=>'email ou password incorrect'],401);
        }
        $user=Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>"logout a été bien fait"],200);
    }
}
