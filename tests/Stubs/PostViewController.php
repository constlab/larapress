<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Resources\Json\JsonResource;
use LaraPress\Controller;

class PostViewController extends Controller
{
    /**
     * @param string $id
     *
     * @return JsonResource
     * @throws BindingResolutionException
     */
    public function __invoke(string $id)
    {
        $modelClassName = $this->getModelClassName();
        $action = $this->getActionClass('view', $modelClassName);

        $data = $action->handle($id);

        return $data;
    }
}
