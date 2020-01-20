<?php

declare(strict_types=1);

namespace LaraPress\Media;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class MediaController
 *
 * @package LaraPress\Media
 */
class MediaController extends Controller
{
    public function index(Request $request)
    {
        // $postType = $request->query('post_type', 'all');
        // $collection = $request->query('collection', 'default');

        $result = Media::query()->get();

        return $result;
    }
}
