<?php

declare(strict_types=1);

namespace LaraPress\Post\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use LaraPress\Post\Post;

class IndexPostAction
{
    protected Post $modelClass;

    protected Request $request;

    /**
     * IndexPostAction constructor.
     *
     * @param string $modelClassName
     * @param Request $request
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(string $modelClassName, Request $request)
    {
        $this->modelClass = app()->make($modelClassName);
        $this->request = $request;
    }

    public function handle(): Collection
    {
        $limit = (int)$this->request->get('limit', 50);
        $offset = (int)$this->request->get('offset', 0);

        $posts = $this->modelClass::query()
            ->orderBy('created_at')
            ->orderBy('order_column')
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $posts;
    }
}
