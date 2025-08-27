<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = Profile::all();
        $companies = Company::all();

        if ($profiles->isEmpty()) {
            $this->command->warn('Brak profili w bazie. Uruchom najpierw ProfileSeeder.');
            return;
        }

        if ($companies->isEmpty()) {
            $this->command->warn('Brak firm w bazie. Uruchom najpierw CompanySeeder.');
            return;
        }

        foreach ($profiles as $profile) {
            $experiencesCount = random_int(1, 3);
            for ($i = 0; $i < $experiencesCount; $i++) {
                Experience::factory()->create([
                    'profile_id' => $profile->id,
                    'company_id' => $companies->random()->id,
                ]);
            }
        }
    }
}
