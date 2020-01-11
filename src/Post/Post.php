<?php

declare(strict_types=1);

namespace LaraPress\Post;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
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

    protected $fillable = ['title', 'slug', 'excerpt', 'post_type', 'order_column'];

    public $incrementing = false;

    protected string $postType;

    /**
     * Post constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $path = explode('\\', get_class($this));
        $this->postType = trim(strtolower((string)array_pop($path)));

        $this->attributes['post_type'] = $this->postType;
    }

    protected static function boot(): void
    {
        static::bootTraits();

        static::creating(function (Model $model) {
            $model->id = Str::uuid();
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

    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        $query = parent::newQuery();
        $query->where('post_type', '=', $this->postType);

        return $query;
    }
}
