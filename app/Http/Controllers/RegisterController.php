<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;

/**
 * RegisterController
 */
class RegisterController extends Controller
{
    /**
     * User register
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request) 
    { 
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        // Check if all fields have been filled
        if ($validator->fails()) {
            return response()->json([
                'error'=>$validator->errors()
            ], 400);
        }
    
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token =  $user->createToken('backend')->accessToken;

        return response()->json([
            'success' => true,
            'token' => $token
        ], 200);
    }
}
