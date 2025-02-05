<?php
namespace Isync\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permission')->insert([
            [
                'vUniqueCode' => '7b026c40b92eb8d1f12141cef5278141484f110803ea9ecca5822072046b6d25c51ce410c124a10e0db5e4b97fc2af39',
                'iRoleId' => 1,
                'iModuleId' => 1,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'dfb42d2940dbe7cd788bcd7eded423979a158358da87cf54d815ac65fd2e0fe133e75ff09dd601bbe69f351039152189',
                'iRoleId' => 1,
                'iModuleId' => 2,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '9f409c7bfb6ff185c9b0dd320b4b30563e26f2212063242455c09366fd65dd4aeccbc87e4b5ce2fe28308fd9f2a7baf3',
                'iRoleId' => 1,
                'iModuleId' => 3,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '238675c6f21b9aeac8bcc182cdae0605884e260097856a27e1b4fddb5be09a97a87ff679a2f3e71d9181a67b7542122c',
                'iRoleId' => 1,
                'iModuleId' => 4,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'bbcf6d644e00a85001fabe76513a2941b1d8e1ddc5f7444d2e579e5b813f2c8fe4da3b7fbbce2345d7772b0674a318d5',
                'iRoleId' => 1,
                'iModuleId' => 5,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'a8619d91e97f2c6969180e2475fa9e48648a6d84d13f8f7f34b0d7b3583c00aa37693cfc748049e45d87b8c7d8b9aacd',
                'iRoleId' => 1,
                'iModuleId' => 6,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '95ab283f1a08cd488b83b80987e41a7b9720236ebc09a55748d25fe85d83a2208e296a067a37563370ded05f5a3bf3ec',
                'iRoleId' => 1,
                'iModuleId' => 7,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '95ab283f1a08cd488b83b5erh46e41a7b9720236ebc09a55748d25fe85d83a2208e296a067a37563370ded05f5a3bf3ec',
                'iRoleId' => 1,
                'iModuleId' => 8,
                'eRead' => 'Yes',
                'eWrite' => 'Yes',
                'eDelete' => 'Yes',
                'dtAddedDate' => now(),
            ]
        ]);
    }
}
