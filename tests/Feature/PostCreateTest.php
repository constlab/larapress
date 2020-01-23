<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_post(): void
    {
        $data = [
            'title' => 'Hello, world!',
            'excerpt' => 'text',
        ];
        $response = $this->post('/api/posts', $data);
        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_create_a_post_and_ignore_unknown_field(): void
    {
        $data = [
            'title' => 'Hello, world!',
            'wrong_column' => 'data',
        ];
        $response = $this->post('/api/posts', $data);
        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_create_a_post_with_thumb(): void
    {
        $data = [
            'title' => 'Hello, world!',
            'thumb' => [
                'image' => UploadedFile::fake()->image('thumb-image.jpg', 1800, 1600),
                'fields' => [
                    'title' => 'Some title'
                ],
            ],
        ];
        $response = $this->post('/api/posts', $data);
        $response->assertStatus(201);

        $post = $response->json();

        $this->assertArrayHasKey('id', $post);
        $this->assertArrayHasKey('name', $post);
        $this->assertArrayHasKey('slug', $post);
        $this->assertArrayHasKey('status', $post);
        $this->assertArrayHasKey('excerpt', $post);
        $this->assertArrayHasKey('thumb', $post);

        $this->assertArrayHasKey('id', $post['thumb']);
        $this->assertArrayHasKey('name', $post['thumb']);
        $this->assertArrayHasKey('fileName', $post['thumb']);
        $this->assertArrayHasKey('fields', $post['thumb']);
        $this->assertArrayHasKey('responsiveImages', $post['thumb']);
        $this->assertArrayHasKey('url', $post['thumb']);
        $this->assertArrayHasKey('srcset', $post['thumb']);

        $this->assertArrayHasKey('title', $post['thumb']['fields']);
        $this->assertEquals('Some title', $post['thumb']['fields']['title']);
    }
}
