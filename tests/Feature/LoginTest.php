<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;

class ExampleTest extends TestCase
{
    /**
     * @return void
     */
    public function testLoginWithoutData()
    {
         $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testLoginWithWrongData()
    {
        $params = ['email' => 'wrong@example.com', 'password' => '123456'];

        $this->json('POST', 'api/login', $params)
            ->assertStatus(401)
            ->assertJson([
                'error' => 'Unauthenticated',
            ]);
    }

    /**
     * @return void
     */
    public function testLoginWithSuccessData()
    {
        $user = factory(User::class)->create([
            'email' => 'user1@example.com',
            'password' => bcrypt('secret'),
        ]);

        $params = ['email' => 'user1@example.com', 'password' => 'secret'];

        $this->json('POST', 'api/login', $params)
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'api_token',
                'created_at',
                'updated_at',
            ]);

    }
}
