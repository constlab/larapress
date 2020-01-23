<?php

declare(strict_types=1);

namespace Tests\Unit;

use LaraPress\Page\Page;
use LaraPress\Post\Post;
use Tests\Stubs\Wiki\Wiki;
use Tests\TestCase;

class HelperTest extends TestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('larapress.post_types.wiki', [
            'model' => Wiki::class,
        ]);
    }

    /** @test */
    public function it_can_get_a_post_name_from_model_class_name(): void
    {
        $page = get_post_type(Page::class);
        $post = get_post_type(Post::class);
        $wiki = get_post_type(Wiki::class);

        $this->assertEquals('page', $page);
        $this->assertEquals('post', $post);
        $this->assertEquals('wiki', $wiki);
    }

    /** @test */
    public function it_can_get_post_type_names_from_config(): void
    {
        $postTypes = get_post_type_names();

        $this->assertIsArray($postTypes);
        $this->assertEquals(['page', 'post', 'wiki'], $postTypes);
    }
}
