<?php

namespace Isync\Demo\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            \Isync\Demo\Database\Seeders\SettingTableSeeder::class,
            \Isync\Demo\Database\Seeders\RoleTableSeeder::class,
            \Isync\Demo\Database\Seeders\PermissionTableSeeder::class,
            \Isync\Demo\Database\Seeders\ModuleTableSeeder::class,
            \Isync\Demo\Database\Seeders\MenuTableSeeder::class,
            \Isync\Demo\Database\Seeders\PaginationTableSeeder::class,
            \Isync\Demo\Database\Seeders\UserTableSeeder::class,
        ]);
    }
}
