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
     * @param string $id
     *
     * @return JsonResource
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(string $id)
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
