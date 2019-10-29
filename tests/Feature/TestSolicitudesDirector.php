<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestSolicitudesDirector extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest123()
    {
        $response = $this->get('/homes');

        $response->assertStatus(200);
    }

    public function testBasicTest222()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testBasicTest223()
    {
        $response = $this->get('/clientes');

        $response->assertStatus(200);
    }
}
