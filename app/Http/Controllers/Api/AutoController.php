<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;


class AutoController extends Controller
{   
    

    public function register(Request $request){

        $request -> validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'

        ]);

        $user = new User();
        $user -> name = $request->name;
        $user -> email = $request->email;
        $user -> password = Hash::make($request->password);
        $user->save();

        return response($user, Response::HTTP_CREATED);

    }

    public function login(Request $request){
        $credentials = $request->validate([
            "email" => 'email|required',
            "password" => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            $cookie = cookie('cookie_token',$token, 60 * 24);
            return response(["token"=>$token], Response::HTTP_OK)->withCookie($cookie);
        }else{
            return response(["message" => "credenciales invalidas"], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function UserProfile(){
        return response()->json([
            "message"=> "userPrfile OK",
            "userData"=>auth()->user()
        ], Response::HTTP_OK);
    }

    public function logout(){
        $cookie = Cookie::forget('cookie_token');
        return response(["message"=>"Cierre de sesion"], Response::HTTP_OK)->withCookie($cookie);
    }

    public function allusers(){
        $users = User::all();
        return response()->json([
            "userData" => $users
        ]);
    }
}
