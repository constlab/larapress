<?php

declare(strict_types=1);

namespace LaraPress\Post\Actions;

use Illuminate\Contracts\Container\BindingResolutionException;
use LaraPress\Post\Post;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Spatie\MediaLibrary\Models\Media;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

/**
 * Class CreatePostAction
 *
 * @package LaraPress\Post\Actions
 */
class CreatePostAction
{
    protected Post $modelClass;

    /**
     * CreatePostAction constructor.
     *
     * @param string $modelClassName
     *
     * @throws BindingResolutionException
     */
    public function __construct(string $modelClassName)
    {
        $this->modelClass = app()->make($modelClassName);
    }

    /**
     * @param array $data
     *
     * @return Post
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws InvalidStatus
     * @throws FileCannotBeAdded
     */
    public function handle(array $data): Post
    {
        /** @var Post $result */
        $result = new $this->modelClass($data);
        $result->save();

        $status = $data['status'] ?? Post::DRAFT_STATUS;
        $result->setStatus($status);

        if (isset($data['thumb']) && is_array($data['thumb'])) {
            $this->attachThumb($data['thumb'], $result);
        }

        return $result;
    }

    /**
     * Attach thumb image to post
     *
     * @param array $thumb
     * @param Post $post
     *
     * @return Media
     * @throws FileCannotBeAdded
     * @throws DiskDoesNotExist
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    private function attachThumb(array $thumb, Post $post): Media
    {
        // $mediaTypes = ['image', 'url'];

        $file = data_get($thumb, 'image', null);
        $fields = data_get($thumb, 'fields', []);

        if ($file !== null) {
            return $post
                ->addMedia($file)
                ->withCustomProperties($fields)
                ->withResponsiveImages()
                ->toMediaCollection('thumb');
        }
        $file = data_get($thumb, 'url', null);
        if ($file !== null) {
            return $post
                ->addMediaFromUrl($file)
                ->withCustomProperties($fields)
                ->withResponsiveImages()
                ->toMediaCollection('thumb');
        }
        abort(500, 'Unknown file type.');
    }

}
