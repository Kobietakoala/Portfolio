<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyTypes = ['Sp. z o.o.', 'S.A.', 'Ltd.', 'Inc.', 'GmbH', 'B.V.'];
        $techWords = ['Tech', 'Digital', 'Solutions', 'Systems', 'Soft', 'Data', 'Cloud', 'Web'];

        $companyName = $this->faker->randomElement($techWords) .
                      $this->faker->randomElement(['Hub', 'Lab', 'Works', 'Pro', 'Plus']) .
                      ' ' .
                      $this->faker->randomElement($companyTypes);

        return [
            'id' => Str::uuid(),
            'name' => $companyName,
            'url' => $this->faker->optional(0.8)->url(),
        ];
    }

    /**
     * Create a startup company.
     */
    public function startup(): static
    {
        $startupNames = [
            'TechStart', 'InnovateLab', 'CodeCraft', 'DevHub', 'SoftwareMakers',
            'DigitalForge', 'CloudVision', 'WebWizards', 'DataDriven', 'SmartSolutions'
        ];

        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement($startupNames),
            'url' => 'https://' . strtolower(str_replace(' ', '', $attributes['name'])) . '.com',
        ]);
    }

    /**
     * Create a large corporation.
     */
    public function corporation(): static
    {
        $corporations = [
            'Microsoft Corporation',
            'Google LLC',
            'Amazon.com Inc.',
            'Apple Inc.',
            'Meta Platforms Inc.',
            'Oracle Corporation',
            'IBM Corporation',
            'Salesforce.com Inc.',
        ];

        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement($corporations),
        ]);
    }

    /**
     * Create a company without website.
     */
    public function withoutWebsite(): static
    {
        return $this->state(fn (array $attributes) => [
            'url' => null,
        ]);
    }
}
