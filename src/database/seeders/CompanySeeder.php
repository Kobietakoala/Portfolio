<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\UniqueConstraintViolationException;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Przykładowe firmy
        $companies = [
            ['name' => 'Google', 'url' => 'https://google.com'],
            ['name' => 'Microsoft', 'url' => 'https://microsoft.com'],
            ['name' => 'Apple', 'url' => 'https://apple.com'],
            ['name' => 'Meta', 'url' => 'https://meta.com'],
            ['name' => 'Amazon', 'url' => 'https://amazon.com'],
            ['name' => 'Netflix', 'url' => 'https://netflix.com'],
            ['name' => 'Tesla', 'url' => 'https://tesla.com'],
            ['name' => 'Adobe', 'url' => 'https://adobe.com'],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['name' => $company['name']],
                $company
            );
        }

        $created = 0;
        $maxAttempts = 50;

        for ($i = 0; $i < $maxAttempts && $created < 15; $i++) {
            try {
                Company::factory()->create();
                $created++;
            } catch (QueryException $e) {
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
