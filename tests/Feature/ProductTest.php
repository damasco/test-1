<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Product;
use App\Category;
use App\User;

class ProductTest extends TestCase
{
    public function testGetListProducts()
    {
        factory(Product::class, 5)->create()->each(function ($product) {
            $product->categories()->save(factory(Category::class)->make());
        });

        $this->json('GET', 'api/products/category/1')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'price', 'created_at', 'updated_at']
                ],
            ]);
    }

    public function testGetProduct()
    {
        $product = factory(Product::class)->create();

        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', '/api/products/' . $product->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $product->name,
                    'categories' => [],
                ]
            ]);
    }

    public function testCreateProduct()
    {
        $category = factory(Category::class)->create();

        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'name' => 'New product',
            'price' => 100,
            'categories' => [$category->id],
        ];

        $this->json('POST', '/api/products', $data, $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'categories' => [$category->id],
                ]
            ]);
    }

    public function testUpdateProduct()
    {
        $product = factory(Product::class)->create();
        $category = factory(Category::class)->create();

        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $data = [
            'name' => 'Product first',
            'price' => 100,
            'categories' => [$category->id],
        ];

        $this->json('PUT', '/api/products/' . $product->id, $data, $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'categories' => $data['categories'],
                ]
            ]);
    }

    public function testDeleteProduct()
    {
        $product = factory(Product::class)->create();

        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('DELETE', '/api/products/' . $product->id, [], $headers)
            ->assertStatus(204);
    }
}