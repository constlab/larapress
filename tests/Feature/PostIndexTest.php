<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PostIndexTest extends TestCase
{
    public function testForGettingPosts(): void
    {
        $response = $this->get('/api/post');
        $response->assertStatus(200);

        $data = data_get($response->json(), 'data', null);
        $this->assertIsArray($data);
        $this->assertCount(50, $data);
    }

    public function testForGettingPostsWithLimit()
    {
        $response = $this->get('/api/post?limit=25');
        $response->assertStatus(200);

        $data = data_get($response->json(), 'data', null);
        $this->assertIsArray($data);
        $this->assertCount(25, $data);
    }
}
