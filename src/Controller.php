<?php

declare(strict_types=1);

namespace LaraPress;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

/**
 * Class Controller
 *
 * @package LaraPress
 */
abstract class Controller extends BaseController
{
    protected array $postTypes = [];

    protected string $type;

    /**
     * Controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        [, $type] = explode('/', $request->path(), 3);
        $type = Str::singular($type);
        $this->postTypes = config('larapress.post_types', []);
        if (!array_key_exists($type, $this->postTypes)) {
            abort(400, 'Bad post type.');
        }
        if ($type !== 'post' && !array_key_exists('post', $this->postTypes)) {
            abort(400, 'Post type not found in config.');
        }
        $this->type = $type;
    }

    /**
     * Get request form class
     * If class does not exists, used CreatePostRequest
     *
     * @param string $requestName
     *
     * @return FormRequest
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getFormRequestClass(string $requestName): FormRequest
    {
        $requestClass = data_get($this->postTypes, [$this->type, $requestName],);
        if ($requestClass === null) {
            $requestClass = $this->postTypes['post'][$requestName];
        }
        return app()->make($requestClass);
    }

    /**
     *  Get action class
     *
     * @param string $actionName
     * @param string|null $modelClassName
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getActionClass(string $actionName, ?string $modelClassName = null)
    {
        $actionName = rtrim($actionName, '-action');
        $actionName = "{$actionName}-action";
        $actionClass = data_get($this->postTypes, [$this->type, $actionName], null);
        if ($actionClass === null) {
            $actionClass = $this->postTypes['post'][$actionName];
        }
        if ($modelClassName === null) {
            $modelClassName = $this->getModelClassName();
        }
        return app()->make($actionClass, ['modelClassName' => $modelClassName]);
    }

    /**
     * Get eloquent model class
     * If does not exists, used Post
     *
     * @return string
     */
    protected function getModelClassName(): string
    {
        $modelClass = data_get($this->postTypes, [$this->type, 'model'], null);
        if ($modelClass === null) {
            $modelClass = $this->postTypes['post']['model'];
        }
        return $modelClass;
    }

    /**
     * Get resource class name
     *
     * @return string
     */
    protected function getResourceClassName(): string
    {
        $resourceClass = data_get($this->postTypes, [$this->type, 'resource'], null);
        if ($resourceClass === null) {
            $resourceClass = $this->postTypes['post']['resource'];
        }
        return $resourceClass;
    }

}
