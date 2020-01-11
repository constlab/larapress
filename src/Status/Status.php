<?php

declare(strict_types=1);

namespace LaraPress\Status;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\ModelStatus\Status as BaseStatus;

class Status extends BaseStatus
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
