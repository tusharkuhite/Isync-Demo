<?php

namespace Isync\Demo\Commands;

use Illuminate\Console\Command;

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
            '--tag' => 'generate-demo-files'
        ]);
    
        $this->call('db:seed', [
            '--class' => 'Isync\\Demo\\Database\\Seeders\\DatabaseSeeder'
        ]);
    
        $this->info('Hello Isync Developer! The setup is complete.');
    }
}
