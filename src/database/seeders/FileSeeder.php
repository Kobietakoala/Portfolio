<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('Brak użytkowników w bazie. Uruchom najpierw UserSeeder.');
            return;
        }

        foreach ($users as $user) {
            File::factory(random_int(3, 8))
                ->forUser($user)
                ->active()
                ->create();

            $avatarFiles = File::factory(random_int(1, 3))
                ->image()
                ->forUser($user)
                ->active()
                ->create();

            $profile = Profile::where('user_id', $user->id)->first();
            if ($profile && $avatarFiles->isNotEmpty()) {
                $profile->update([
                    'avatar' => $avatarFiles->first()->id
                ]);
            }

            File::factory(random_int(0, 2))
                ->forUser($user)
                ->archived()
                ->create();
        }
    }
}
