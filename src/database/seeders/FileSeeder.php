<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            File::factory(rand(5, 15))
                ->state(['created_by' => $user->id])
                ->create();

            File::factory(rand(2, 5))
                ->image()
                ->state(['created_by' => $user->id])
                ->create();
        }
    }
}
