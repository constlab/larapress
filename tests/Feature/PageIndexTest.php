<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PageIndexTest extends TestCase
{
    /** @test */
    public function it_can_get_pages(): void
    {
        $response = $this->get('/api/pages');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(20, $data);
    }
}
