<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Str;
use LaraPress\Post\Post;
use Tests\TestCase;

class PostDeleteTest extends TestCase
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
    public function it_can_delete_post()
    {
        $post = Post::query()->inRandomOrder()->currentStatus(Post::PUBLISH_STATUS)->limit(1)->first();
        $this->assertNotNull($post);

        $response = $this->delete("/api/posts/{$post->id}");
        $response->assertStatus(204);
    }

    /** @test */
    public function it_returns_404_when_deleting_not_exists_post()
    {
        $postId = Str::uuid();
        $response = $this->delete("/api/posts/{$postId}");
        $response->assertStatus(404);
    }

    /** @test */
    public function it_returns_405_when_request_not_contains_uuid()
    {
        $response = $this->delete("/api/posts/wrong-format-id");
        $response->assertStatus(405); // Method not allowed
    }
}
