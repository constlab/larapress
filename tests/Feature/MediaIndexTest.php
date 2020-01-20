<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class MediaIndexTest extends TestCase
{
    public function testForGettingMedia(): void
    {
        $response = $this->get('/api/media');
        $response->assertStatus(200);

        // $data = data_get($response->json(), 'data', null);
        // $this->assertIsArray($data);
        // $this->assertCount(20, $data);
    }
}
