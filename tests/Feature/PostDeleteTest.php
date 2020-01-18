<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Str;
use LaraPress\Post\Post;
use Tests\TestCase;

class PostDeleteTest extends TestCase
{
    public function testForDeletingPost()
    {
        $post = Post::query()->inRandomOrder()->currentStatus(Post::PUBLISH_STATUS)->limit(1)->first();
        $this->assertNotNull($post);

        $asd = "/api/posts/{$post->id}";
        $response = $this->delete($asd);
        $response->assertStatus(204);
    }

    public function testForDeletingWithWrongId()
    {
        $postId = Str::uuid();
        $response = $this->delete("/api/posts/{$postId}");
        $response->assertStatus(404);
    }

    public function testForDeleteRequestWithWringIDFormat()
    {
        $response = $this->delete("/api/posts/wrong-format-id");
        $response->assertStatus(405); // Method not allowed
    }
}
