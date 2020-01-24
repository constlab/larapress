<?php

declare(strict_types=1);

namespace LaraPress\Post\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * @return AnonymousResourceCollection
     * @throws BindingResolutionException
     */
    public function __invoke(Request $request)
    {
        $action = $this->getActionClass('index');
        /** @var PostResource $resource */
        $resource = $this->getResourceClassName();

        $data = $action->handle();

        return $resource::collection($data);
    }
}
