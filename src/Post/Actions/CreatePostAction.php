<?php

declare(strict_types=1);

namespace LaraPress\Post\Actions;

use LaraPress\Post\Post;

class CreatePostAction
{
    protected Post $modelClass;

    /**
     * CreatePostAction constructor.
     *
     * @param string $modelClassName
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $modelClassName)
    {
        $this->modelClass = app()->make($modelClassName);
    }

    /**
     * @param array $data
     *
     * @return Post
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function handle(array $data): Post
    {
        /** @var Post $result */
        $result = new $this->modelClass($data);
        $result->save();

        $status = $data['status'] ?? Post::DRAFT_STATUS;
        $result->setStatus($status);

        return $result;
    }

}
