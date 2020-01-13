<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use LaraPress\Post\Post;

$factory->define(Post::class, function (Faker $faker) {
    $data = [
        'id' => Str::uuid(),
        'title' => $faker->title,
        'slug' => $faker->slug,
        'post_type' => 'post',
        'excerpt' => $faker->text,
    ];
    return $data;
});
