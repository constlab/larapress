<?php

declare(strict_types=1);

namespace LaraPress\Post\Controllers;

use LaraPress\Controller;
use LaraPress\Post\Actions\CreatePostAction;
use LaraPress\Post\Resources\PostResource;

/**
 * Class PostCreateController
 *
 * @package LaraPress\Post\Controllers
 */
class PostCreateController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function __invoke()
    {
        /// Validate request data

        $formRequest = $this->getFormRequestClass('create-request');
        $data = $formRequest->validated();

        /// Create Post model

        /** @var CreatePostAction $action */
        $action = $this->getActionClass('create');
        $post = $action->handle($data);

        /// Get resource class
        /// If does not exists, used PostResource

        /** @var PostResource $resourceClass */
        $resourceClass = $this->getResourceClassName();

        $result = $resourceClass::make($post);

        return response()->json($result, 201);
    }
}
