<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PostIndexTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../../database/factories');
        $this->seed();
    }

    /** @test */
    public function it_can_get_posts(): void
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(50, $data);
    }

    /** @test */
    public function it_can_get_posts_with_limit()
    {
        $response = $this->get('/api/posts?limit=25');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(25, $data);
    }
}
