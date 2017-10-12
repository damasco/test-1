<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Category;
use App\User;
use App\Product;

class CategoryTest extends TestCase
{
    public function testGetListCategory()
    {
        factory(Product::class, 5)->create()->each(function ($product) {
            $product->categories()->save(factory(Category::class)->make());
        });
        
        $this->json('GET', '/api/categories')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'created_at', 'updated_at']
                ],
            ]);
    }

    public function testGetCategory()
    {
        $category = factory(Category::class)->create([
            'name' => 'Category name',
        ]);

        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('GET', '/api/categories/' . $category->id, [], $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Category name',
                ]
            ]);
    }

    public function testCreateCategory()
    {
        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/categories', ['name' => 'New category'], $headers)
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'name' => 'New category',
                ]
            ]);
    }

    public function testUpdateCategory()
    {
        $category = factory(Category::class)->create([
            'name' => 'Category update name',
        ]);

        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('PUT', '/api/categories/' . $category->id, ['name' => 'Updated category'], $headers)
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'Updated category',
                ]
            ]);
    }

    public function testDeleteCategory()
    {
        $category = factory(Category::class)->create();

        $user = factory(User::class)->create();
        $token = $user->api_token;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('DELETE', '/api/categories/' . $category->id, [], $headers)
            ->assertStatus(204);
    }
}
