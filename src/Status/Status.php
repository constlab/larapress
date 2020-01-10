<?php

declare(strict_types=1);

namespace LaraPress\Status;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Spatie\ModelStatus\Status as BaseStatus;

class Status extends BaseStatus
{
    public $incrementing = false;

    protected static function boot(): void
    {
        static::bootTraits();

        static::creating(function (Model $model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }
}
