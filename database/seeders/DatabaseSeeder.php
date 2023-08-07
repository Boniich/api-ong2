<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Member;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        makeAndDeleteDirectory('members');
        makeAndDeleteDirectory('organization');

        $this->call(ContactSeeder::class);

        Member::factory(5)->create();
        Organization::factory(1)->create();
    }
}
