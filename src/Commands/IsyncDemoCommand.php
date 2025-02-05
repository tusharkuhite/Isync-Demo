<?php

namespace Isync\Demo\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class IsyncDemoCommand extends Command
{
    
    protected $signature = 'isync:demo';

    protected $description = 'This is a custom command for manage everything in one call';

    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'vendor/isync/demo/src/Database/Migrations/2025_01_03_085311_create_module_table.php'
        ]);
        
        $this->call('vendor:publish', [
            '--tag' => 'generate-demo-files',
            '--force' => true
        ]);
    
        $this->call('db:seed', [
            '--class' => 'Isync\\Demo\\Database\\Seeders\\DatabaseSeeder'
        ]);

        $publishableFiles = [
            __DIR__ . '../models' => app_path('Models'),
            __DIR__ . '../Controllers' => app_path('Http/Controllers'),
            __DIR__ . '../Middleware/' => app_path('Http/Middleware/'),
            __DIR__ . '../views/layouts' => resource_path('views/layouts'),
            __DIR__ . '../views/admin' => resource_path('views/admin'),
            __DIR__ . '../Assets/' => public_path(),
            __DIR__ . '../General/' => app_path('Libraries/'),
            __DIR__ . '../routes/generatedRoute.php' => base_path('routes/web.php'),
            __DIR__ . '../models/User.php' => app_path('Models/User.php')
        ];


        // foreach (array_keys($publishableFiles) as $fileOrDir) {
        //     if (File::exists($fileOrDir)) {
        //         File::delete($fileOrDir);
        //     }

        //     if (File::isDirectory($fileOrDir)) {
        //         File::deleteDirectory($fileOrDir);
        //     }
        // }
    
        $this->info('Hello Isync Developer! The setup is complete.');
    }
}
