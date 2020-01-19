<?php

declare(strict_types=1);

namespace LaraPress\Post\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraPress\Media\Resources\MediaResource;
use LaraPress\Media\Resources\ThumbResource;

/**
 * @method getFirstMedia(string $string)
 *
 * @property string id
 * @property string title
 * @property string slug
 * @property string status
 * @property string created_at
 * @property string updated_at
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $thumb = $this->getFirstMedia('thumb');

        return [
            'id' => $this->id,
            'name' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'excerpt' => $this->excerpt ?? '',
            'thumb' => $thumb ? ThumbResource::make($thumb) : null,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
