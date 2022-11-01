<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestFeed extends TestCase {

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example() {
        $response = $this->post('/api/feed', ['content' => 1, 'upload_id' => 2]);
        $response->assertStatus(201);
        $response = $this->put('/api/feed/1', ['content' => 1, 'upload_id' => 2]);
        $response->assertStatus(200);
        // $response = $this->delete('/api/feed/1');
        //$response->assertStatus(204);
        return;
        $response = $this->post('/api/upload', ['file' => 'asdfasdf']);
        $response->assertStatus(204);
    }
}
