<?php
namespace Isync\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('role')->insert([
            [
                'vUniqueCode' => '55bb9d04489bf34213598b1921bfe0f61011929ea142bde1283f8bfdcdcde3a8',
                'vRole' => 'Admin',
                'vCode' => 'AD',
                'eStatus' => 'Active',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '4b624ecc57e606a7c905fa71404b30930671384ce261e8e9405c4218bed2b281a87ff679a2f3e71d9181a67b7542122c',
                'vRole' => 'Sub Admin',
                'vCode' => 'SAD',
                'eStatus' => 'Active',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '22d970434a2749a0b8bfb7f00a6c9e7dd02a2daea6000a986037078cf3d38c571679091c5a880faf6fb5e6087eb1b2dc',
                'vRole' => 'SEO',
                'vCode' => 'SEO',
                'eStatus' => 'Active',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '26df2ca365db1f8571384f1caeaf9ddce24cadc3b3175492f72eb3679a60ed478f14e45fceea167a5a36dedd4bea2543',
                'vRole' => 'Content Writer',
                'vCode' => 'CW',
                'eStatus' => 'Active',
                'dtAddedDate' => now(),
            ],
        ]);
    }
}
