<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

/**
 * LoginController
 */
class LoginController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }
    
    /**
     * User login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        // Validate Products's fields
        $this->validator($request);
        
        // Get only email and password from the request
        $credentials = $request->only('email', 'password');

        // Attempt to login with these credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('backend')->accessToken;
            $user_client = [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'token' => $token
            ];
            return response()->json([
                'success' => true,
                'user' => $user_client
            ] , 200);
        } else {
            return response()->json([
                'error' => 'Unauthorised'
            ], 401);
        }
    }
}
