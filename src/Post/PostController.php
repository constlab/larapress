<?php

declare(strict_types=1);

namespace LaraPress\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraPress\Controller;
use LaraPress\Post\Actions\CreatePostAction;
use LaraPress\Post\Resources\PostResource;

/**
 * Class PostController
 *
 * @package LaraPress\Post
 */
class PostController extends Controller
{
    // public function __construct()
    // {
    // $this->middleware('auth:api', ['except' => ['index', 'show']]);
    //}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index(Request $request)
    {
        $action = $this->getActionClass('index');
        /** @var PostResource $resource */
        $resource = $this->getResourceClassName();

        $data = $action->handle();
        $result = $resource::collection($data);

        return response()->json(['data' => $result]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store()
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

    /**
     * @param string $id
     * @param Request $request
     *
     * @return JsonResource
     * @throws \Throwable
     */
    public function show(string $id, Request $request): JsonResource
    {
        $modelClassName = $this->getModelClassName();
        $action = $this->getActionClass('view', $modelClassName);
        /** @var JsonResource $resourceClass */
        $resourceClass = $this->getResourceClassName();

        $data = $action->handle($id);
        $result = $resourceClass::make($data);

        return $result;
    }
}
