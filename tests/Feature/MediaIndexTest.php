<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class MediaIndexTest extends TestCase
{
    /** @test */
    public function it_can_get_media(): void
    {
        $response = $this->get('/api/media');
        $response->assertStatus(200);

        // $data = $response->json('data');
        // $this->assertIsArray($data);
        // $this->assertCount(20, $data);
    }
}
