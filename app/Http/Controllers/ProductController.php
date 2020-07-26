<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

/**
 * ProductController
 */
class ProductController extends Controller
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
            'name' => 'required|string',
            'description' => 'required|string'
        ]);
    }

    /**
     * Show products according to user's role
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $user = Auth::user();

        // Check user's role. It must be SP or AP to see all products
        if ($user->role == 0 || $user->role == 1) {
            $products = Product::all();
        } else {
            $products = Product::where('status', 1)->get();
        }

        return response()->json([
            'products' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        $user = Auth::user();

        // Check user's role. It must be SP
        if ($user->role != 0) {
            return response()->json([
                'error' => 'Unauthorised'
            ], 401);
        }
        
        // Validate Products's fields
        $this->validator($request);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 0
        ]);

        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, Product $product)
    {
        $user = Auth::user();

        // Check user's role. It must be AP
        if ($user->role != 1) {
            return response()->json([
                'error' => 'Unauthorised'
            ], 401);
        }
        
        $product->status = 1;
        $product->save();

        return response()->json([
            'product' => $product
        ], 200);
    }
}
