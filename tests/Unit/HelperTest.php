<?php

declare(strict_types=1);

namespace Tests\Unit;

use LaraPress\LaraPressServiceProvider;
use LaraPress\Page\Page;
use LaraPress\Post\Post;
use Orchestra\Testbench\TestCase;
use Tests\Stubs\Wiki\Wiki;

class HelperTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [LaraPressServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('larapress.post_types.wiki', [
            'model' => Wiki::class,
        ]);
    }

    public function testForGettingPostTypeFromModelClassName(): void
    {
        $page = get_post_type(Page::class);
        $post = get_post_type(Post::class);
        $wiki = get_post_type(Wiki::class);

        $this->assertEquals('page', $page);
        $this->assertEquals('post', $post);
        $this->assertEquals('wiki', $wiki);
    }

    public function testForGettingPOstTypeNames(): void
    {
        $postTypes = get_post_type_names();

        $this->assertIsArray($postTypes);
        $this->assertEquals(['page', 'post', 'wiki'], $postTypes);
    }
}
