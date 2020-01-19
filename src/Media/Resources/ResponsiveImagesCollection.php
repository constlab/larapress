<?php

declare(strict_types=1);

namespace LaraPress\Media\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ResponsiveImagesCollection
 *
 * @package LaraPress\Media\Resources
 */
class ResponsiveImagesCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [

        ];
    }
}
