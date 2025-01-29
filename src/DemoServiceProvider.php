<?php

namespace Isync\Demo;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

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

        if ($this->app->runningInConsole() && $this->isPublishing('generate-demo-files')) {
            $this->updateWebRoutes();
            $this->replaceContentInUserModel();
        }

    }

    private function updateWebRoutes()
    {
        $generatedRoutePath = __DIR__ . '/routes/generatedRoute.php';
        $webRoutePath = base_path('routes/web.php');

        if (File::exists($generatedRoutePath) && File::exists($webRoutePath)) {
            $generatedRouteLines = file($generatedRoutePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $webRouteContent = file($webRoutePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            $missingLines = [];

            foreach ($generatedRouteLines as $line) {
                
                if (!in_array($line, $webRouteContent)) {
                    $missingLines[] = $line;
                }
            }

            if (!empty($missingLines)) {
                File::append($webRoutePath, PHP_EOL . implode(PHP_EOL, $missingLines) . PHP_EOL);
            } 
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
            File::put($userModelPath, $newContent);  // Write the new content to the file

        } 
    }

    public function register()
    {
        if (file_exists(__DIR__ . '/helpers.php')) {
            require_once __DIR__ . '/helpers.php';
        }
    }
}
