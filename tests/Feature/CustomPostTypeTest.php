<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\Stubs\Wiki\Wiki;
use Tests\TestCase;

class CustomPostTypeTest extends TestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('larapress.post_types.wiki', [
            'model' => Wiki::class,
        ]);
    }

    /** @test */
    public function it_can_get_custom_posts(): void
    {
        $response = $this->get('/api/wikis');
        $response->assertStatus(200);

        $data = $response->json('data');
        $this->assertIsArray($data);
    }

    /** @test */
    public function it_can_create_a_custom_post(): void
    {
        $data = [
            'title' => 'New wiki post',
            'excerpt' => 'custom post type',
        ];
        $response = $this->post('/api/wikis', $data);
        $response->assertStatus(201);

        $wikiPost = Wiki::query()->where('title', '=', 'New wiki post')->take(1)->first();
        $this->assertNotNull($wikiPost);
        $this->assertEquals('new-wiki-post', $wikiPost->slug);
        $this->assertEquals($data['excerpt'], $wikiPost->excerpt);
        $this->assertEquals('wiki', $wikiPost->post_type);
    }
}
