<?php
namespace Isync\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('module')->insert([
            [
                'vUniqueCode' => '82f96dd5e5f2dd8f1e20e90a5aebffc32d42d078382bc16247096d4cb300abe2a87ff679a2f3e71d9181a67b7542122c',
                'iRoleId'     => 1,
                'iMenuId'     => 1,
                'vModule'     => 'Menu',
                'vController' => 'MenuController',
                'eStatus'     => 'Active',
                'iOrder'      => 1,
                'eFeature'    => 'Yes',
                'eDelete'     => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '96f30b5312d572bde28fd461b189b2e5a035ae44b5f73578b8bd0f8f4a40a8311ff1de774005f8da13f42943881c655f',
                'iRoleId'     => 1,
                'iMenuId'     => 1,
                'vModule'     => 'Module',
                'vController' => 'ModuleController',
                'eStatus'     => 'Active',
                'iOrder'      => 2,
                'eFeature'    => 'Yes',
                'eDelete'     => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '37025060652fb7b9251178c06c0906075738b57dc6e95e3e3023588a3e1b2a756512bd43d9caa6e02c990b0a82652dca',
                'iRoleId'     => 1,
                'iMenuId'     => 1,
                'vModule'     => 'Permission',
                'vController' => 'PermissionController',
                'eStatus'     => 'Active',
                'iOrder'      => 3,
                'eFeature'    => 'Yes',
                'eDelete'     => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '82f96dd5e5f2dd8f1e20e90a5aebffc32d42d078382bc16247096d4cb300abe2a87ff679a2f3e71d9181a67b7542122c',
                'iRoleId'     => 1,
                'iMenuId'     => 2,
                'vModule'     => 'Dashboard',
                'vController' => 'DashboardController',
                'eStatus'     => 'Active',
                'iOrder'      => 1,
                'eFeature'    => 'Yes',
                'eDelete'     => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '82f96dd5e5f2dd8f1e20e90a5aebffc32d42d078382bc16247096d4cb300abe2a87ff679a2f3e71d9181a67b7542122c',
                'iRoleId'     => 1,
                'iMenuId'     => 3,
                'vModule'     => 'Admin',
                'vController' => 'AdminController',
                'eStatus'     => 'Active',
                'iOrder'      => 1,
                'eFeature'    => 'Yes',
                'eDelete'     => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'cd89cc99232f3983fde7f805b5c451fadcfef028d36296b28fef93fe3a2db46b98f13708210194c475687be6106a3b84',
                'iRoleId'     => 1,
                'iMenuId'     => 4,
                'vModule'     => 'Setting',
                'vController' => 'SettingController',
                'eStatus'     => 'Active',
                'iOrder'      => 1,
                'eFeature'    => 'Yes',
                'eDelete'     => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'cf268b0a12b85aa2f1d6225a8ab6c319a26944b156963e03b5d37ea807d70a12b6d767d2f8ed5d21a44b0e5886680cb9',
                'iRoleId'     => 1,
                'iMenuId'     => 4,
                'vModule'     => 'Meta',
                'vController' => 'MetaController',
                'eStatus'     => 'Active',
                'iOrder'      => 2,
                'eFeature'    => 'Yes',
                'eDelete'     => 'No',
                'dtAddedDate' => now(),
            ]
        ]);
    }
}
