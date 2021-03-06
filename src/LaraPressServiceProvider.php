<?php

declare(strict_types=1);

namespace LaraPress;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\ModelStatus\ModelStatusServiceProvider;
use Spatie\QueryBuilder\QueryBuilderServiceProvider;

/**
 * Class LaraPressServiceProvider
 *
 * @package LaraPress
 */
class LaraPressServiceProvider extends ServiceProvider
{
    protected $urlParams = [
        'id' => '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}',
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/medialibrary.php' => config_path('medialibrary.php'),
            __DIR__ . '/../config/model-status.php' => config_path('model-status.php'),
            __DIR__ . '/../config/larapress.php' => config_path('larapress.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations/2013_07_26_182750_create_media_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_media_table.php'),
        ], 'migrations');

        $this->loadMigrationsFrom(realpath(__DIR__ . '/../database/migrations'));

        $this->registerRoutes();
        $this->registerMediaRoutes();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/larapress.php', 'larapress');
        $this->mergeConfigFrom(__DIR__ . '/../config/model-status.php', 'model-status');
        $this->mergeConfigFrom(__DIR__ . '/../config/medialibrary.php', 'medialibrary');

        $this->app->register(ModelStatusServiceProvider::class);
        $this->app->register(MediaLibraryServiceProvider::class);
        $this->app->register(QueryBuilderServiceProvider::class);
    }

    protected function registerRoutes(): void
    {
        $postTypes = config('larapress.post_types', []);
        $postTypeNames = get_post_type_names();

        foreach ($postTypeNames as $postType) {
            $indexController = data_get($postTypes, [$postType, 'index-controller'], '\LaraPress\Post\Controllers\PostIndexController');
            $viewController = data_get($postTypes, [$postType, 'view-controller'], '\LaraPress\Post\Controllers\PostViewController');
            $createController = data_get($postTypes, [$postType, 'create-controller'], '\LaraPress\Post\Controllers\PostCreateController');
            $updateController = data_get($postTypes, [$postType, 'update-controller'], '\LaraPress\Post\Controllers\PostUpdateController');
            $deleteController = data_get($postTypes, [$postType, 'delete-controller'], '\LaraPress\Post\Controllers\PostDeleteController');

            $routeName = Str::plural($postType);

            Route::where($this->urlParams)->group(function (Router $route) use ($routeName, $indexController, $viewController, $createController, $updateController, $deleteController) {
                $route->get("/api/{$routeName}", (string)$indexController);
                $route->get("/api/{$routeName}/{idSlug}", (string)$viewController);
                $route->post("/api/{$routeName}", (string)$createController);
                $route->put("/api/{$routeName}/{id}", (string)$updateController);
                $route->delete("/api/{$routeName}/{id}", (string)$deleteController);
            });
        }
    }

    protected function registerMediaRoutes()
    {
        Route::where($this->urlParams)->group(function (Router $route) {
            $route->get('/api/media', '\LaraPress\Media\MediaController@index');
        });
    }
}
