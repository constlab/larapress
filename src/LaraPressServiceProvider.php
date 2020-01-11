<?php

declare(strict_types=1);

namespace LaraPress;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\ModelStatus\ModelStatusServiceProvider;

class LaraPressServiceProvider extends ServiceProvider
{
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

        $this->app->register(ModelStatusServiceProvider::class);
        $this->app->register(MediaLibraryServiceProvider::class);
    }

    protected function registerRoutes(): void
    {
        $config = config('larapress.post_types', []);
        $postTypes = array_keys($config);
        foreach ($postTypes as $postType) {
            $indexController = data_get($config, [$postType, 'index-controller'], '\LaraPress\Post\Controllers\PostIndexController');
            $viewController = data_get($config, [$postType, 'view-controller'], '\LaraPress\Post\Controllers\PostViewController');
            $createController = data_get($config, [$postType, 'create-controller'], '\LaraPress\Post\Controllers\PostCreateController');
            $updateController = data_get($config, [$postType, 'update-controller'], '\LaraPress\Post\Controllers\PostUpdateController');
            $deleteController = data_get($config, [$postType, 'delete-controller'], '\LaraPress\Post\Controllers\PostDeleteController');

            Route::get("/api/{$postType}", (string)$indexController);
            Route::get("/api/{$postType}/{id}", (string)$viewController);
            Route::post("/api/{$postType}", (string)$createController);
            Route::put("/api/{$postType}/{id}", (string)$updateController);
            Route::delete("/api/{$postType}/{id}", (string)$deleteController);
        }
    }
}
