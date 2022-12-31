<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $payload = [
            "email" => "admin@egmail.com",
            "password" => "password"
        ];
 
        $this->post('/api/auth-signin', $payload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        'token',
                        'name',
                    ],
                    'message',
                ]
            );
    }
}
