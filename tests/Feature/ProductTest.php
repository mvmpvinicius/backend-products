<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\User;

class ProductTest extends TestCase
{    
    /**
     * testShowProductsSuccessfully
     * Test showing products with existent user and its token
     *
     * Expect success with 200
     */
    public function testShowProductsSuccessfully()
    {
        $user = factory(User::class)->create();
        $token = $user->createToken('backend')->accessToken;
        
        $headers = [
            'Authorization' => "Bearer $token",
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'accept'        => 'application/json'
        ];

        $payload = [];

        $this->json('GET', 'api/product', $payload, $headers)
            ->assertStatus(200);

        $user->delete();
    }
    
    /**
     * testShowProductsUnauthorized
     * Test showing products with unauthorized user
     *
     * Expect failure with 401
     */
    public function testShowProductsUnauthorized()
    {
        $user = factory(User::class)->create();
        
        $headers = [
            'Authorization' => "Bearer faketoken",
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'accept'        => 'application/json'
        ];

        $payload = [];

        $this->json('GET', 'api/product', $payload, $headers)
            ->assertStatus(401);

        $user->delete();
    }
    
    /**
     * testCreateProductSuccessfully
     * Test creating a product successfully
     *
     * Expect success with 200
     */
    public function testCreateProductSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'testing@email.com',
            'password' => bcrypt('password'),
            'role' => 0,
        ]);
        $token = $user->createToken('backend')->accessToken;

        $headers = [
            'Authorization' => "Bearer $token",
        ];

        $payload = [
            'name' => 'Product test',
            'description' => 'Description test',
        ];

        $this->json('POST', 'api/product', $payload, $headers)
            ->assertStatus(200);

        $user->delete();
    }

     /**
     * testCreateProductUnauthorizedRole
     * Test creating a product with an unauthorized role
     *
     * Expect failure with 401
     */
    public function testCreateProductUnauthorizedRole()
    {
        $user = factory(User::class)->create([
            'email' => 'testing@email.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);
        $token = $user->createToken('backend')->accessToken;

        $headers = [
            'Authorization' => "Bearer $token",
        ];

        $payload = [
            'name' => 'Product test',
            'description' => 'Description test',
        ];

        $this->json('POST', 'api/product', $payload, $headers)
            ->assertStatus(401);

        $user->delete();
    }
    
    /**
     * testApproveProductSuccessfully
     * Test approving a product successfully
     *
     * Expect success with 200
     */
    public function testApproveProductSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'testing@email.com',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);
        $token = $user->createToken('backend')->accessToken;

        $headers = [
            'Authorization' => "Bearer $token",
        ];

        $product = factory(Product::class)->create([
            'name' => 'Product test',
            'description' => 'Description test'
        ]);

        $payload = [];

        $this->json('PUT', "api/product/$product->id", $payload, $headers)
            ->assertStatus(200);

        $product->delete();
        $user->delete();
    }

    /**
     * testApproveProductUnauthorizedRole
     * Test approving a product with an unauthorized role
     *
     * Expect failure with 401
     */
    public function testApproveProductUnauthorizedRole()
    {
        $user = factory(User::class)->create([
            'email' => 'testing@email.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);
        $token = $user->createToken('backend')->accessToken;

        $headers = [
            'Authorization' => "Bearer $token",
        ];

        $product = factory(Product::class)->create([
            'name' => 'Product test',
            'description' => 'Description test'
        ]);

        $payload = [];

        $this->json('PUT', "api/product/$product->id", $payload, $headers)
            ->assertStatus(401);

        $product->delete();
        $user->delete();
    }
}
