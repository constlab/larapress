<?php

declare(strict_types=1);

namespace LaraPress\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    public $incrementing = false;

    protected static function boot(): void
    {
        static::bootTraits();

        static::creating(function (Model $model) {
            $model->id = Str::uuid();
        });
    }
}
