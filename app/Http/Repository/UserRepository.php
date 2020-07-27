<?php

namespace App\Http\Repository;

use App\User;

class UserRepository
{
    /**      
     * @var Model      
     */     
    protected $model;

    /**
    * UserRepository constructor
    *
    * @param User $model
    */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    
    /**
     * Create a new user
     *
     * @param  array $attributes
     * @return Collection
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }
}