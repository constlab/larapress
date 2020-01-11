<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class PageIndexTest extends TestCase
{
    public function testForGettingPages(): void
    {
        $response = $this->get('/api/page');
        $response->assertStatus(200);

        $data = data_get($response->json(), 'data', null);
        $this->assertIsArray($data);
        $this->assertCount(20, $data);
    }
}
