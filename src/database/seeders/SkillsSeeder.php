<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $created = 0;
        $maxAttempts = 50;

        for ($i = 0; $i < $maxAttempts && $created < 15; $i++) {
            try {
                Skill::factory()->create();
                $created++;
            } catch (QueryException $e) {
                // Przechwycenie naruszenia unikatowości (SQLSTATE 23000)
                $isUniqueViolation = ($e->getCode() === '23000')
                    || (($e->errorInfo[0] ?? null) === '23000');

                if (!$isUniqueViolation) {
                    throw $e;
                }
                continue;
            }
        }

    }
}
