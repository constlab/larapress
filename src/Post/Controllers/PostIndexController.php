<?php

declare(strict_types=1);

namespace LaraPress\Post\Controllers;

use Illuminate\Http\Request;
use LaraPress\Controller;
use LaraPress\Post\Resources\PostResource;

/**
 * Class PostIndexController
 *
 * @package LaraPress\Post\Controllers
 */
class PostIndexController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(Request $request)
    {
        $action = $this->getActionClass('index');
        /** @var PostResource $resource */
        $resource = $this->getResourceClassName();

        $data = $action->handle();
        $result = $resource::collection($data);

        return response()->json(['data' => $result]);
    }
}
