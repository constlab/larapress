<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use LaraPress\Post\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $statuses = [Post::DRAFT_STATUS, Post::PENDING_STATUS, Post::PUBLISH_STATUS];

        factory(Post::class, 50)->create()->each(function (Post $post) use ($statuses) {
            $statusIndex = rand(0, count($statuses) - 1);
            $post->setStatus($statuses[$statusIndex]);

            $thumb = UploadedFile::fake()->image('thumb-image.jpg', 800, 600);

            $post->addMedia($thumb)
                ->withCustomProperties([
                    'title' => 'Some title',
                ])
                ->withResponsiveImages()
                ->toMediaCollection('thumb');;
        });
    }
}
