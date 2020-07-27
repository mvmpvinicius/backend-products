<?php

namespace App\Http\Repository;

use App\Product;

class ProductRepository
{
    /**      
     * @var Model      
     */     
    protected $model;

    /**
    * ProductRepository constructor
    *
    * @param Product $model
    */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    
    /**
     * Create a new product
     *
     * @param  array $attributes
     * @return Collection
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }
    
    /**
     * Get all products
     *
     * @return Collection
     */
    public function get()
    {
        return $this->model->all();    
    }

    /**
     * Get products by status
     *
     * @param  $status
     * @return Collection
     */
    public function getByStatus($status)
    {
        return $this->model->where('status', $status)->get();
    }
    
    /**
     * Approve product
     *
     * @param  App\Product
     * @return Collection
     */
    public function approve(Product $product)
    {
        $product->status = 1;
        $product->save();

        return $product;
    }
}