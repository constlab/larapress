<?php

declare(strict_types=1);

namespace Tests\Feature;

use LaraPress\Post\Post;
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

        $statuses = [Post::DRAFT_STATUS, Post::PENDING_STATUS, Post::PUBLISH_STATUS];

        factory(Post::class, 35)->create()->each(function (Post $post) use ($statuses) {
            $statusIndex = rand(0, count($statuses) - 1);
            $post->setStatus($statuses[$statusIndex]);
        });
    }

    /** @test */
    public function it_can_get_posts(): void
    {
        $response = $this->get('/api/posts');
        $response->assertStatus(200);

        $result = $response->json();
        $data = data_get($result, 'data', null);
        $meta = data_get($result, 'meta', null);
        $links = data_get($result, 'links', null);

        $this->assertIsArray($data);
        $this->assertIsArray($meta);
        $this->assertIsArray($links);

        $this->assertCount(20, $data);
    }

    /** @test */
    public function it_can_get_posts_from_second_page(): void
    {
        $response = $this->get('/api/posts?page=2');
        $response->assertStatus(200);

        $result = $response->json();
        $data = data_get($result, 'data', null);
        $meta = data_get($result, 'meta', null);
        $links = data_get($result, 'links', null);

        $this->assertIsArray($data);
        $this->assertIsArray($meta);
        $this->assertIsArray($links);

        $this->assertEquals(2, $meta['current_page']);
        $this->assertEquals(2, $meta['last_page']);
        $this->assertEquals(20, $meta['per_page']);
        $this->assertEquals(35, $meta['total']);

        $this->assertCount(15, $data); // 20 items per page, second page has 15 items
    }

    /** @test */
    public function it_can_get_posts_with_custom_page_size(): void
    {
        $response = $this->get('/api/posts?perPage=5');
        $response->assertStatus(200);

        $result = $response->json();
        $data = data_get($result, 'data', null);
        $meta = data_get($result, 'meta', null);
        $links = data_get($result, 'links', null);

        $this->assertIsArray($data);
        $this->assertIsArray($meta);
        $this->assertIsArray($links);

        $this->assertEquals(1, $meta['current_page']);
        $this->assertEquals(7, $meta['last_page']);
        $this->assertEquals(5, $meta['per_page']);

        $this->assertCount(5, $data);
    }

    /** @test */
    public function it_can_get_post_with_sort(): void
    {
        $response = $this->get('/api/posts?sort=title,-updatedAt'); // allowed values: title, createdAt, updatedAt, orderColumn
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(20, $data);

        $postIds = Post::query()->orderBy('title')->orderBy('updated_at', 'desc')->limit(20)->get()->pluck('id')->toArray();
        $postIdsFromApi = collect($data)->pluck('id')->toArray();

        $this->assertEquals($postIds, $postIdsFromApi);
    }

    /** @test */
    public function it_can_get_posts_with_filter(): void
    {
        $post = Post::query()->inRandomOrder(1)->first();

        $response = $this->get("/api/posts?filter[title]={$post->title}"); // allowed column for filter: title, excerpt, status
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertTrue(count($data) >= 1);
    }

    /** @test */
    public function it_can_get_posts_with_pending_status(): void
    {
        $response = $this->get('/api/posts?filter[status]=pending');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);

        $statuses = collect($data)->pluck('status')
            ->filter(function (string $item) {
                return $item !== 'pending';
            })
            ->toArray();

        $this->assertEmpty($statuses);
    }

    /** @test */
    public function it_can_get_posts_with_complex_query(): void
    {
        $response = $this->get('/api/posts?sort=title&perPage=15&page=2');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(15, $data);
    }
}
