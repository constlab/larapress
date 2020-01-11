<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use LaraPress\Page\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $statuses = [Page::DRAFT_STATUS, Page::PUBLISH_STATUS];

        factory(Page::class, 20)->create()->each(function (Page $post) use ($statuses) {
            $statusIndex = rand(0, count($statuses) - 1);
            $post->setStatus($statuses[$statusIndex]);
        });
    }
}
