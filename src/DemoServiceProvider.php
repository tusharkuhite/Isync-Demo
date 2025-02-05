<?php

namespace Isync\Demo;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Isync\Demo\Commands\IsyncDemoCommand;

class DemoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'demo');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        $publishableFiles = [
            __DIR__ . '/models' => app_path('Models'),
            __DIR__ . '/Controllers' => app_path('Http/Controllers'),
            __DIR__ . '/Middleware/' => app_path('Http/Middleware/'),
            __DIR__ . '/views/layouts' => resource_path('views/layouts'),
            __DIR__ . '/views/admin' => resource_path('views/admin'),
            __DIR__ . '/Assets/' => public_path(),
            __DIR__ . '/General/' => app_path('Libraries/'),
            __DIR__ . '/routes/generatedRoute.php' => base_path('routes/web.php'),
            __DIR__ . '/models/User.php' => app_path('Models/User.php')
        ];

        $this->publishes($publishableFiles, 'generate-demo-files');

        if ($this->app->runningInConsole()) {
            $this->commands([
                IsyncDemoCommand::class,
            ]);
        }

    }

    public function register()
    {
        if (file_exists(__DIR__ . '/helpers.php')) {
            require_once __DIR__ . '/helpers.php';
        }
    }
}
