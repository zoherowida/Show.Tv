<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = [
            'email' => 'testemail@test.com',
            'password' => 'passwordtest',
        ];
        $request = new Request($user);

        $response = $this->json('POST', '/vueLogin',$user);
        dd($response);
        $response->assertStatus(200);
    }
}
