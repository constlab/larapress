<?php

declare(strict_types=1);

namespace LaraPress\Post\Actions;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraPress\Post\Post;
use Ramsey\Uuid\Uuid;

class ViewPostAction
{
    protected Post $modelClass;

    /**
     * ViewPostAction constructor.
     *
     * @param string $modelClassName
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $modelClassName)
    {
        $this->modelClass = app()->make($modelClassName);
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function handle(string $id)
    {
        $isId = Uuid::isValid($id);
        $post = $this->modelClass::query()
            ->when($isId, function (Builder $query) use ($id) {
                return $query->find($id);
            })
            ->when(!$isId, function (Builder $query) use ($id) {
                return $query->where('slug', '=', $id);
            })
            ->limit(1)
            ->first();

        throw_if($post === null, new ModelNotFoundException('Post not found.'));

        return $post;
    }
}
