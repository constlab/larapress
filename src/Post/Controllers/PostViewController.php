<?php

declare(strict_types=1);

namespace LaraPress\Post\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use LaraPress\Controller;

/**
 * Class PostViewController
 *
 * @package LaraPress\Post\Controllers
 */
class PostViewController extends Controller
{
    /**
     * @param string $idSlug ID or slug
     *
     * @return JsonResource
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(string $idSlug)
    {
        $modelClassName = $this->getModelClassName();
        $action = $this->getActionClass('view', $modelClassName);
        /** @var JsonResource $resourceClass */
        $resourceClass = $this->getResourceClassName();

        $data = $action->handle($idSlug);
        $result = $resourceClass::make($data);

        return $result;
    }
}
