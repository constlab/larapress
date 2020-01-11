<?php

declare(strict_types=1);

namespace LaraPress\Post\Controllers;

use Illuminate\Http\Request;
use LaraPress\Controller;

/**
 * Class PostUpdateController
 *
 * @package LaraPress\Post\Controllers
 */
class PostUpdateController extends Controller
{
    public function __invoke(string $id, Request $request)
    {
        return $id;
    }
}
