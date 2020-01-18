<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Str;
use LaraPress\Post\Post;
use Tests\TestCase;

class PostViewTest extends TestCase
{
    public function testForGettingPostById(): void
    {
        $post = Post::query()->first();
        $response = $this->get("/api/posts/{$post->id}");
        $response->assertStatus(200);
    }

    public function testForGettingPostBySlugWithDraftStatus(): void
    {
        $post = Post::currentStatus(Post::DRAFT_STATUS)->first();
        $this->assertNotNull($post);
        $response = $this->get("/api/posts/{$post->slug}");
        $response->assertStatus(404);
    }

    public function testForGettingPostBySlug(): void
    {
        $post = Post::currentStatus(Post::PUBLISH_STATUS)->first();
        $this->assertNotNull($post);
        $response = $this->get("/api/posts/{$post->slug}");
        $response->assertStatus(200);
    }

    public function testForGettingNotExistingPost(): void
    {
        $id = Str::uuid();
        $response = $this->get("/api/posts/{$id}");
        $response->assertStatus(404);
    }
}
