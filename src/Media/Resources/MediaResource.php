<?php

declare(strict_types=1);

namespace LaraPress\Media\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * Class MediaResource
 *
 * @package LaraPress\Media\Resources
 *
 * @method getFullUrl(): string
 * @method getUrl(): string
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
class MediaResource extends JsonResource
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
            'id' => $this->id,
            'postType' => get_post_type($this->model_type),
            'postId' => $this->model_id,
            'collection' => $this->collection_name,
            'name' => $this->name,
            'fileName' => $this->file_name,
            'mimeType' => $this->mime_type,
            'size' => $this->size,
            'manipulations' => $this->manipulations,
            'fields' => $this->custom_properties,
            'responsiveImages' => $this->responsive_images,
            'orderColumn' => $this->order_column,
            'url' => $this->getUrl(),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
