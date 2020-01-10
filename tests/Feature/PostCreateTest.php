<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PostCreateTest extends TestCase
{
    public function testForCreatingPost(): void
    {
        $data = [
            'title' => 'Hello, world!',
            'wrong_column' => 'data',
        ];
        $response = $this->post('/api/post', $data);
        $response->assertStatus(201);

        // $result = $response->json();
        // dd($result);
    }
}
