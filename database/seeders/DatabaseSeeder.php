<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Member;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Slide;
use App\Models\SocialMediaItem;
use App\Models\Testimonial;
use App\Models\User;
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
        makeAndDeleteDirectory('projects');
        makeAndDeleteDirectory('testimonials');
        makeAndDeleteDirectory('socialMediaItems');
        makeAndDeleteDirectory('users');
        makeAndDeleteDirectory('slides');
        makeAndDeleteDirectory('categories');

        $this->call(ContactSeeder::class);

        Member::factory(5)->withImage()->create();
        Organization::factory(1)->create();
        Project::factory(5)->create();
        Testimonial::factory(5)->withImage()->create();

        SocialMediaItem::factory(5)->withImage()->create();
        User::factory(5)->withImage()->create();
        Slide::factory(5)->create();
        Category::factory(5)->create();
    }
}
