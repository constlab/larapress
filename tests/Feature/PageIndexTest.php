<?php

declare(strict_types=1);

namespace Tests\Feature;

use LaraPress\Page\Page;
use Tests\TestCase;

class PageIndexTest extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__ . '/../../database/factories');
        $statuses = [Page::DRAFT_STATUS, Page::PENDING_STATUS, Page::PUBLISH_STATUS];

        factory(Page::class, 35)->create()->each(function (Page $page) use ($statuses) {
            $statusIndex = rand(0, count($statuses) - 1);
            $page->setStatus($statuses[$statusIndex]);
        });
    }

    /** @test */
    public function it_can_get_pages(): void
    {
        $response = $this->get('/api/pages');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(20, $data);
    }

    /** @test */
    public function it_can_get_pages_with_limit()
    {
        $response = $this->get('/api/pages?perPage=25');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(25, $data);
    }
}
