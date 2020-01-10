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
        $postTypes = array_keys(config('larapress.post_types', []));
        foreach ($postTypes as $postType) {
            Route::get("/api/{$postType}", '\LaraPress\Post\PostController@index');
            Route::get("/api/{$postType}/{id}", '\LaraPress\Post\PostController@show');
            Route::post("/api/{$postType}", '\LaraPress\Post\PostController@store');
            Route::put("/api/{$postType}/{id}", '\LaraPress\Post\PostController@update');
            Route::delete("/api/{$postType}/{id}", '\LaraPress\Post\PostController@delete');
        }
    }
}
