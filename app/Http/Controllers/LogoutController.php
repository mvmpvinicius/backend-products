<?php

namespace App\Http\Controllers;

/**
 * LogoutController
 */
class LogoutController extends Controller
{
    /**
     * Logout user
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        Auth::logout();

        return response()->json([
            'success' => true
        ], 200);
    }
}
