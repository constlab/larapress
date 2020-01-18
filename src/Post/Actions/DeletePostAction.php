<?php

declare(strict_types=1);

namespace LaraPress\Post\Actions;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraPress\Post\Post;

/**
 * Class DeletePostAction
 *
 * @package LaraPress\Post\Actions
 */
class DeletePostAction
{
    /**
     * @param string $id
     *
     * @return bool
     * @throws \Throwable
     */
    public function handle(string $id): bool
    {
        $post = Post::query()->find($id);
        throw_if(!$post, new ModelNotFoundException("Post with id {$id} not found."));

        return $post->delete();
    }
}
