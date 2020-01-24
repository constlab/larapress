<?php

declare(strict_types=1);

namespace LaraPress\Post\Actions;

use Illuminate\Contracts\Pagination\Paginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class IndexPostAction
 *
 * @package LaraPress\Post\Actions
 */
class IndexPostAction
{
    protected string $modelClassName;

    /**
     * IndexPostAction constructor.
     *
     * @param string $modelClassName
     *
     */
    public function __construct(string $modelClassName)
    {
        $this->modelClassName = $modelClassName;
    }

    /**
     * @return Paginator
     */
    public function handle(): Paginator
    {
        $perPage = request()->query->getInt('perPage', 20);

       return QueryBuilder::for($this->modelClassName)
            ->allowedFields('id', 'status', 'thumb')
            ->allowedSorts([
                'title',
                AllowedSort::field('orderColumn', 'order_column'),
                AllowedSort::field('createdAt', 'created_at'),
                AllowedSort::field('updatedAt', 'updated_at'),
            ])
            ->defaultSorts('order_column', '-created_at')
            ->allowedFilters([
                'title',
                'excerpt',
                AllowedFilter::scope('status', 'currentStatus'),
            ])
            ->paginate($perPage);
    }
}
