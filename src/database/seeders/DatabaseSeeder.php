<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Experience;
use App\Models\File;
use App\Models\Profile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            ProfileSeeder::class,
            ExperienceSeeder::class,
            FileSeeder::class,
            SkillsSeeder::class
        ]);
    }
}
