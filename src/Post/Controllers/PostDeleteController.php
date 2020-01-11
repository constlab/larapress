<?php

declare(strict_types=1);

namespace LaraPress\Post\Controllers;

use LaraPress\Controller;

/**
 * Class PostDeleteController
 *
 * @package LaraPress\Post\Controllers
 */
class PostDeleteController extends Controller
{
    public function __invoke(string $id)
    {
        return $id;
    }
}
