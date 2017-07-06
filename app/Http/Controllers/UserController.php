<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $content = [];

        if (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ])) {
            $user = Auth::user();
            $content['token'] = $user->createToken('Pizza App')->accessToken;
        }

        return response()->json($content, 200);
    }
}