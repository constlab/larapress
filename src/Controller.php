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
        $postTypes = [$this->type, 'post'];
        foreach ($postTypes as $postType) {
            $requestClass = data_get($this->postTypes, [$postType, $requestName], null);
            if ($requestClass !== null) {
                break;
            }
        }
        abort_if($requestClass === null, 500, "Request class for request name '{$requestName}' not found.");
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
        $postTypes = [$this->type, 'post'];
        foreach ($postTypes as $postType) {
            $actionClass = data_get($this->postTypes, [$postType, $actionName], null);
            if ($actionClass !== null) {
                break;
            }
        }
        abort_if($actionClass === null, 500, "Action class for action '{$actionName}' not found.");
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
        abort_if($modelClass === null, 500, "Model class '{$this->type}' not found.");
        return $modelClass;
    }

    /**
     * Get resource class name
     *
     * @return string
     */
    protected function getResourceClassName(): string
    {
        $postTypes = [$this->type, 'post'];
        foreach ($postTypes as $postType) {
            $resourceClass = data_get($this->postTypes, [$postType, 'resource'], null);
            if ($resourceClass !== null) {
                break;
            }
        }
        abort_if($resourceClass === null, 500, "Resource class for post type '{$this->type}' not found.");
        return $resourceClass;
    }

}
