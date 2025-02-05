<?php
namespace Isync\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaginationTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pagination')->insert([
            [
                'vUniqueCode' => '0e2af7a4d14216ddc4524acd8502bb6c121fd183b4fc7c1e3e37a8ef19b63a56c4ca4238a0b923820dcc509a6f75849b',
                'vController' => 'MenuController',
                'vSize' => '10',
                'eStatus' => 'Active',
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '53131a7763a26f80053cd47233eb01dd276ca8b66dc6e41ac3780460611e8c00c81e728d9d4c2f636f067f89cc14862c',
                'vController' => 'ModuleController',
                'vSize' => '10',
                'eStatus' => 'Active',
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '187cb05f8b1c272c12cd283bfd36a9f9a8ca867533089171e9c4eed65c0df8daeccbc87e4b5ce2fe28308fd9f2a7baf3',
                'vController' => 'PermissionController',
                'vSize' => '10',
                'eStatus' => 'Active',
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => '19c093c696e059273475e30599ba4217c6ee365d99190e4870e897caddb69395a87ff679a2f3e71d9181a67b7542122c',
                'vController' => 'AdminController',
                'vSize' => '10',
                'eStatus' => 'Active',
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
            [
                'vUniqueCode' => 'feedf5da80491f4aa55042998dcc181a8368122964a48987cbe81677840cad88e4da3b7fbbce2345d7772b0674a318d5',
                'vController' => 'MetaController',
                'vSize' => '10',
                'eStatus' => 'Active',
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ],
        ]);
    }
}
