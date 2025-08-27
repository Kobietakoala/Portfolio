<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $companies = Company::all();

        foreach ($users as $user) {
            $experiencesCount = rand(2, 5);

            Experience::factory($experiencesCount)->create([
                'user_id' => $user->id,
                'company_id' => $companies->random()->id,
            ]);
        }
    }
}
