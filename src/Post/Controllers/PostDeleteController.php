<?php

declare(strict_types=1);

namespace LaraPress\Post\Controllers;

use Illuminate\Http\Response;
use LaraPress\Controller;
use LaraPress\Post\Actions\DeletePostAction;

/**
 * Class PostDeleteController
 *
 * @package LaraPress\Post\Controllers
 */
class PostDeleteController extends Controller
{

    /**
     * @param string $id
     *
     * @return Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Throwable
     */
    public function __invoke(string $id): Response
    {
        /** @var DeletePostAction $action */
        $action = $this->getActionClass('delete');
        $action->handle($id);
        return response('', 204);
    }
}
