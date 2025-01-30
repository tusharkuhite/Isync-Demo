<?php

namespace Isync\Demo;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageServiceProvider;

class DemoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'demo');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');

        
        $this->publishes([
            __DIR__ . '/models' => app_path('Models'),
            __DIR__ . '/Controllers' => app_path('Http/Controllers'),
            __DIR__ . '/views/layouts' => resource_path('views/layouts'),
            __DIR__ . '/views/admin' => resource_path('views/admin'),
            __DIR__ . '/Assets/' => public_path(),
            __DIR__ . '/General/' => app_path('Libraries/')
        ], 'generate-demo-files');

        $this->publishes([
            __DIR__.'/../config/image.php' => config_path('image.php'),
        ]);

        if ($this->app->runningInConsole() && $this->isPublishing('generate-demo-files')) {
            $this->updateWebRoutes();
            $this->replaceContentInUserModel();
        }

    }

    private function updateWebRoutes()
    {
        $generatedRoutePath = __DIR__ . '/routes/generatedRoute.php';
        $webRoutePath = base_path('routes/web.php');

        if (File::exists($webRoutePath)) {
            
            $newContent = File::get($generatedRoutePath);
            File::put($webRoutePath, $newContent);  

        } 
    }

    private function isPublishing($tag)
    {
        return in_array('vendor:publish', request()->server('argv', [])) &&
            in_array('--tag=' . $tag, request()->server('argv', []));
    }
    
    private function replaceContentInUserModel()
    {
        $userModelPath = app_path('Models/User.php');

        if (File::exists($userModelPath)) {
            
            $newContent = File::get(__DIR__ . '/models/User.php');
            File::put($userModelPath, $newContent);  

        } 
    }

    public function register()
    {
        $this->app->register(ImageServiceProvider::class);

        if (file_exists(__DIR__ . '/helpers.php')) {
            require_once __DIR__ . '/helpers.php';
        }
    }
}
