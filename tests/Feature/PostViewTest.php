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
        $response = $this->get("/api/post/{$post->id}");
        $response->assertStatus(200);
    }

    public function testForGettingPostBySlug(): void
    {
        $post = Post::query()->first();
        $response = $this->get("/api/post/{$post->slug}");
        $response->assertStatus(200);
    }

    public function testForGettingNotExistingPost(): void
    {
        $id = Str::uuid();
        $response = $this->get("/api/post/{$id}");
        $response->assertStatus(404);
    }
}
