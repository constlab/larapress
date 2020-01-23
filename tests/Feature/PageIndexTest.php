<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PageIndexTest extends TestCase
{
    use DatabaseMigrations;

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
    public function it_can_get_pages(): void
    {
        $response = $this->get('/api/pages');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(50, $data);
    }

    /** @test */
    public function it_can_get_pages_with_limit()
    {
        $response = $this->get('/api/pages?limit=25');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(25, $data);
    }
}
