<?php

declare(strict_types=1);

namespace LaraPress\Media\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * Class ThumbResource
 *
 * @package LaraPress\Media\Resources
 *
 * @method getUrl(): string
 * @method getSrcset(): string
 *
 * @property string id
 * @property string model_type
 * @property string model_id
 * @property string collection_name
 * @property string name
 * @property string file_name
 * @property string mime_type
 * @property integer size
 * @property array manipulations
 * @property array custom_properties
 * @property array responsive_images
 * @property integer order_column
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class ThumbResource extends JsonResource
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
        $responsiveImages = $this->responsive_images;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'fileName' => $this->file_name,
            'fields' => $this->custom_properties,
            'responsiveImages' => data_get($responsiveImages, 'medialibrary_original', []),
            'url' => $this->getUrl(),
            'srcset' => $this->getSrcset(),
        ];
    }
}
