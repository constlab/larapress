<?php

return [

    'post_types' => [

        'post' => [
            'model' => \LaraPress\Post\Post::class,
            'resource' => \LaraPress\Post\Resources\PostResource::class,
            'create-request' => \LaraPress\Post\Requests\CreatePostRequest::class,
            'update-request' => \LaraPress\Post\Requests\CreatePostRequest::class,
            'index-action' => \LaraPress\Post\Actions\IndexPostAction::class,
            'view-action' => \LaraPress\Post\Actions\ViewPostAction::class,
            'create-action' => \LaraPress\Post\Actions\CreatePostAction::class,
            'delete-action' => \LaraPress\Post\Actions\DeletePostAction::class,
        ],

        'page' => [
            'model' => \LaraPress\Page\Page::class,
        ],

    ]
];

