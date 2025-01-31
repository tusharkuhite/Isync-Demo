<?php

namespace MyPackage\Commands;

use Illuminate\Console\Command;

class IsyncCommand extends Command
{
    // The command signature used to call it in the terminal
    protected $signature = 'isync:demo';

    // Command description
    protected $description = 'This is a custom command for manage everything in one call';

    public function handle()
    {
        $this->call('migrate', [
            '--path' => 'Isync/Demo/src/Database/Migrations/2025_01_03_085311_create_module_table.php'
        ]);

        // Publish service provider files
        $this->call('vendor:publish', [
            '--provider' => "Isync\Demo\DemoServiceProvider"
        ]);
    
        // Publish files under a specific tag
        $this->call('vendor:publish', [
            '--tag' => 'generate-demo-files'
        ]);
    
        // Run the database seeder
        $this->call('db:seed', [
            '--class' => 'Isync\\Demo\\Database\\Seeders\\DatabaseSeeder'
        ]);
    
        // Display a success message
        $this->info('Hello Isync Developer! The setup is complete.');
    }
}
