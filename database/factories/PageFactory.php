<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use LaraPress\Page\Page;

$factory->define(Page::class, function (Faker $faker) {
    $data = [
        'id' => Str::uuid(),
        'title' => $faker->text,
        'slug' => $faker->slug,
        'post_type' => 'page',
        'excerpt' => $faker->text,
    ];
    return $data;
});
