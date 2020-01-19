<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PostCreateTest extends TestCase
{
    public function testForCreatingPost(): void
    {
        $data = [
            'title' => 'Hello, world!',
            'wrong_column' => 'data',
        ];
        $response = $this->post('/api/posts', $data);
        $response->assertStatus(201);
    }

    public function testForCreatePostWithThumb(): void
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
