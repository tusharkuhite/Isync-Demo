<?php
namespace Isync\Demo\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    public function run()
    {
<<<<<<< HEAD
        DB::table('user')->insert([
=======
        DB::table('users')->insert([
>>>>>>> 594515e (testing)
            [
                'vUniqueCode' => 'U12345',
                'iRoleId' => 1,
                'vFirstName' => 'John',
                'vLastName' => 'Doe',
                'vEmail' => 'admin@admin.com',
                'vPassword' => md5('Admin@123'),
                'eStatus' => 'Active',
                'eDelete' => 'No',
                'dtAddedDate' => now(),
            ]
        ]);
    }
}
