<?php

declare(strict_types=1);

namespace LaraPress\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements Sortable
{
    use SoftDeletes, HasSlug, HasStatuses, SortableTrait;

    const PUBLISH_STATUS = 'publish';
    const DRAFT_STATUS = 'draft';
    const PENDING_STATUS = 'pending';

    protected $table = 'post';

    protected $fillable = ['title', 'excerpt', 'order_column'];

    public $incrementing = false;

    protected static function boot(): void
    {
        static::bootTraits();

        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
