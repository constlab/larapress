<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use LaraPress\Post\Post;

$factory->define(Post::class, function (Faker $faker) {
    $data = [
        'id' => Ramsey\Uuid\Uuid::uuid4()->toString(),
        'title' => $faker->text(50),
        'slug' => $faker->slug(),
        'excerpt' => $faker->text(),
    ];
    return $data;
});
