<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $normalUser = new User;
        $normalUser->name = 'Normal user';
        $normalUser->email = 'user@gmail.com';
        $normalUser->password = '123456';

        $normalUser->assignRole(2)->save();

        $adminUser = new User;
        $adminUser->name = 'Admin user';
        $adminUser->email = 'admin@gmail.com';
        $adminUser->password = '123456';

        $adminUser->assignRole(1)->save();
    }
}
