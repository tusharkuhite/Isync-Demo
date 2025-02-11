<?php

namespace Isync\Demo\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class IsyncDemoCommand extends Command
{
    protected $signature = 'isync:demo';
    protected $description = 'This is a custom command to manage everything in one call';

    public function handle()
    {
        $this->info("🚀 Starting Isync Demo setup...\n");

        // Show loading effect
        $this->showLoading("🔄 Running migrations...");
        $this->callSilent('migrate', [
            '--path' => 'vendor/isync/demo/src/Database/Migrations/2025_01_03_085311_create_module_table.php'
        ]);
        $this->info("✅ Migration completed.\n");

        $this->showLoading("📂 Publishing package files...");
        $this->callSilent('vendor:publish', [
            '--tag' => 'generate-demo-files',
            '--force' => true
        ]);
        $this->info("✅ Files published successfully.\n");

        $this->showLoading("🌱 Running database seeder...");
        $this->callSilent('db:seed', [
            '--class' => 'Isync\\Demo\\Database\\Seeders\\DatabaseSeeder'
        ]);
        $this->info("✅ Seeding completed.\n");

        $this->showLoading("🗑️ Cleaning up old files...");
        $this->cleanupFiles();
        $this->info("✅ Cleanup complete.\n");

        $this->info("\n🎉 Hello Isync Developer! The setup is complete.");
    }

    private function showLoading($message)
    {
        $this->output->write($message);
        for ($i = 0; $i < 3; $i++) {
            sleep(1);
            $this->output->write('.');
        }
        $this->info(""); 
    }

    private function cleanupFiles()
    {
        $publishableFiles = [
            __DIR__ . '/../models' => app_path('Models'),
            __DIR__ . '/../Controllers' => app_path('Http/Controllers'),
            __DIR__ . '/../Middleware/' => app_path('Http/Middleware/'),
            __DIR__ . '/../views/layouts' => resource_path('views/layouts'),
            __DIR__ . '/../views/admin' => resource_path('views/admin'),
            __DIR__ . '/../Assets/' => public_path(),
            __DIR__ . '/../General/' => app_path('Libraries/'),
            __DIR__ . '/../routes/generatedRoute.php' => base_path('routes/web.php'),
            __DIR__ . '/../models/User.php' => app_path('Models/User.php')
        ];

        foreach (array_keys($publishableFiles) as $fileOrDir) {
            if (File::exists($fileOrDir)) {
                File::delete($fileOrDir);
            }
            if (File::isDirectory($fileOrDir)) {
                File::deleteDirectory($fileOrDir);
            }
        }
    }
}
