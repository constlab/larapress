<?php

declare(strict_types=1);

namespace LaraPress\Post\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'excerpt' => 'sometimes|string',
            'slug' => 'sometimes|string',
            'order_column' => 'sometimes|numeric',
            'thumb.image' => 'image',
            'thumb.url' => 'string',
            'thumb.fields' => 'sometimes|array'
        ];
    }
}
