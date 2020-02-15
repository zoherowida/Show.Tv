<?php

namespace Tests\Feature;

use App\Http\Controllers\VueController;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EpisodesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = [
            'id' => 'Eşkıya Dünyaya Hükümdar Olmaz',
        ];
        $request = new Request($user);

        $response = $this->json('POST', '/json/Episode',$user);
        dd($response);
        $response
            ->assertStatus(200);

    }
}
