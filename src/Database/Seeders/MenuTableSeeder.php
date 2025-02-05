<?php
namespace Isync\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('menu')->insert([
            [
                'vUniqueCode' => '9c4a5f40e7c6ff30ef67ff6b655a543f46ce9a23e7d8d3d3028e3eae0e8f4e8ee4da3b7fbbce2345d7772b0674a318d5',
                'vMenu' => 'Permissions',
                'iRoleId' => 1,
                'eStatus' => 'Active',
                'vCode' => 'bx bx-lock',
                'eFeature' => 'Yes',
                'iOrder'    => 7 ,
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'e52e359dc6eec765a8cd10004f5d741d1b8c027ffed254c11cd3494fe50328b7c81e728d9d4c2f636f067f89cc14862c',
                'vMenu' => 'Dashboard',
                'iRoleId' => 1,
                'eStatus' => 'Active',
                'vCode' => 'bx bx-home-circle',
                'eFeature' => 'Yes',
                'iOrder'    => 1 ,
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'fbd7696444ac65dd0d3e4af05bf9162e527908c6fefb0162a85db32af5d466aba87ff679a2f3e71d9181a67b7542122c',
                'vMenu' => 'User',
                'iRoleId' => 1,
                'eStatus' => 'Active',
                'vCode' => 'bx bx-cog',
                'eFeature' => 'Yes',
                'iOrder'    => 3,
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '8f8b613e8f9f66931d7c80832cdce83a55ed005ac2239c905cc9c217713535dcc9f0f895fb98ab9159f51fd0297e236d',
                'vMenu' => 'Settings',
                'iRoleId' => 1,
                'eStatus' => 'Active',
                'vCode' => 'bx bx-cog',
                'eFeature' => 'Yes',
                'iOrder'    => 9,
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
<<<<<<< HEAD
=======
            [
                'vUniqueCode' => '8f8b613e8f9f66931d7c80834fth583a55ed005ac2239c905cc9c217713535dcc9f0f895fb98ab9159f51fd0297e236d',
                'vMenu' => 'Profile',
                'iRoleId' => 1,
                'eStatus' => 'Active',
                'vCode' => '',
                'eFeature' => 'Yes',
                'iOrder'    => 2,
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ]
>>>>>>> 594515e (testing)
        ]);
    }
}
