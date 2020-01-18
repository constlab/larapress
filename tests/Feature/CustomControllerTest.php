<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\Stubs\PostViewController;
use Tests\TestCase;

class CustomControllerTest extends TestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('larapress.post_types.post.view-controller', PostViewController::class);
    }

    public function testForViewCustomController(): void
    {
        $response = $this->post('/api/posts', [
            'title' => 'New Post',
            'status' => 'publish',
        ]);
        $response->assertStatus(201);

        $post = $response->json();

        $viewResponse = $this->get("/api/posts/{$post['id']}");
        $viewResponse->assertStatus(200);

        $viewPost = $viewResponse->json();
        $this->assertArrayHasKey('order_column', $viewPost);
        $this->assertArrayHasKey('deleted_at', $viewPost);
        $this->assertArrayHasKey('created_at', $viewPost);
        $this->assertArrayHasKey('updated_at', $viewPost);
    }
}
