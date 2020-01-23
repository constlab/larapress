<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Str;
use LaraPress\Post\Post;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class PostViewTest extends TestCase
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

    private function assertResponseData(array $data): void
    {
        $this->assertArrayHasKey('id', $data);
        $this->assertTrue(Uuid::isValid($data['id']));

        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('slug', $data);

        $this->assertArrayHasKey('status', $data);
        $this->assertContains($data['status'], [Post::PUBLISH_STATUS, Post::DRAFT_STATUS, Post::PENDING_STATUS]);

        $this->assertArrayHasKey('excerpt', $data);

        $this->assertArrayHasKey('thumb', $data);
        $this->assertIsArray($data['thumb']);

        $this->assertArrayHasKey('createdAt', $data);
        $this->assertArrayHasKey('updatedAt', $data);
    }

    /** @test */
    public function it_can_get_post_by_id(): void
    {
        $post = Post::query()->inRandomOrder()->limit(1)->first();
        $this->assertNotNull($post);

        $response = $this->get("/api/posts/{$post->id}");
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertResponseData($data);
    }

    /** @test */
    public function it_returns_404_when_getting_draft_post_by_slug(): void
    {
        $post = Post::currentStatus(Post::DRAFT_STATUS)->inRandomOrder()->limit(1)->first();
        $this->assertNotNull($post);

        $response = $this->get("/api/posts/{$post->slug}");
        $response->assertStatus(404);
    }

    /** @test */
    public function it_can_get_draft_post_by_id(): void
    {
        $post = Post::currentStatus(Post::DRAFT_STATUS)->inRandomOrder()->limit(1)->first();
        $this->assertNotNull($post);

        $response = $this->get("/api/posts/{$post->id}");
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertResponseData($data);
    }

    /** @test */
    public function it_can_get_post_by_slug(): void
    {
        $post = Post::currentStatus(Post::PUBLISH_STATUS)->inRandomOrder()->limit(1)->first();
        $this->assertNotNull($post);

        $response = $this->get("/api/posts/{$post->slug}");
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertResponseData($data);
    }

    /** @test */
    public function it_returns_404_when_getting_not_exists_post(): void
    {
        $id = Str::uuid();
        $response = $this->get("/api/posts/{$id}");
        $response->assertStatus(404);
    }
}
