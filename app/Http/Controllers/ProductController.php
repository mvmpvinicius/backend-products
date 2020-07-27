<?php

namespace App\Http\Controllers;

use App\Http\Repository\ProductRepository;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ProductController
 */
class ProductController extends Controller
{    
    /**
     * productRepository
     */
    private $productRepository;
    
    /**
     * __construct
     *
     * @param  App\Http\Repository\ProductRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

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
            $products = $this->productRepository->get();
        } else {
            $products = $this->productRepository->getByStatus(1);
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

        // Insert a new product after checks
        $product = $this->productRepository->create([
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

        // Approve product after checks
        $this->productRepository->approve($product);
        
        return response()->json([
            'product' => $product
        ], 200);
    }
}
