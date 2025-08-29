<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use App\Models\Experience;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $positions = [
            'pl' => [
                'Senior PHP Developer',
                'Full Stack Developer',
                'Backend Developer',
                'Frontend Developer',
                'Software Engineer',
                'Technical Lead',
                'DevOps Engineer',
                'Junior Developer',
                'Mid-level Developer',
            ],
            'en' => [
                'Senior PHP Developer',
                'Full Stack Developer',
                'Backend Developer',
                'Frontend Developer',
                'Software Engineer',
                'Technical Lead',
                'DevOps Engineer',
                'Junior Developer',
                'Mid-level Developer',
            ],
        ];

        $descriptions = [
            'pl' => [
                'Rozwój aplikacji webowych w technologii PHP i Laravel. Współpraca z zespołem frontend oraz DevOps.',
                'Projektowanie i implementacja REST API. Optymalizacja wydajności baz danych.',
                'Mentoring młodszych programistów. Uczestnictwo w procesie rekrutacji.',
                'Implementacja mikroserwisów. Integracja z zewnętrznymi API.',
                'Refaktoryzacja legacy kodu. Wprowadzanie dobrych praktyk programistycznych.',
            ],
            'en' => [
                'Development of web applications using PHP and Laravel. Collaboration with frontend and DevOps teams.',
                'Design and implementation of REST APIs. Database performance optimization.',
                'Mentoring junior developers. Participation in recruitment processes.',
                'Microservices implementation. Integration with external APIs.',
                'Legacy code refactoring. Introduction of programming best practices.',
            ],
        ];

        $startDate = $this->faker->dateTimeBetween('-5 years', '-1 month');
        $endDate = $this->faker->optional(0.3)->dateTimeBetween($startDate, 'now');

        return [
            'id' => Str::uuid(),
            'profile_id' => Profile::factory(),
            'company_id' => Company::factory(),
            'position' => [
                'pl' => $this->faker->randomElement($positions['pl']),
                'en' => $this->faker->randomElement($positions['en']),
            ],
            'description' => [
                'pl' => $this->faker->randomElement($descriptions['pl']),
                'en' => $this->faker->randomElement($descriptions['en']),
            ],
            'since' => $startDate,
            'until' => $endDate,
        ];
    }

    /**
     * Create a current job (no end date).
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'until' => null,
            'since' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ]);
    }

    /**
     * Create a past job.
     */
    public function past(): static
    {
        $startDate = $this->faker->dateTimeBetween('-8 years', '-2 years');
        $endDate = $this->faker->dateTimeBetween($startDate, '-1 year');

        return $this->state(fn (array $attributes) => [
            'since' => $startDate,
            'until' => $endDate,
        ]);
    }

    /**
     * Create a short-term job (less than 6 months).
     */
    public function shortTerm(): static
    {
        $startDate = $this->faker->dateTimeBetween('-2 years', '-6 months');
        $endDate = Carbon::parse($startDate)->addMonths($this->faker->numberBetween(1, 5));

        return $this->state(fn (array $attributes) => [
            'since' => $startDate,
            'until' => $endDate,
        ]);
    }

    /**
     * Create a long-term job (more than 2 years).
     */
    public function longTerm(): static
    {
        $startDate = $this->faker->dateTimeBetween('-6 years', '-3 years');
        $endDate = $this->faker->optional(0.5)->dateTimeBetween(
            Carbon::parse($startDate)->addYears(2),
            'now'
        );

        return $this->state(fn (array $attributes) => [
            'since' => $startDate,
            'until' => $endDate,
        ]);
    }

    /**
     * Create experience with specific position level.
     */
    public function seniorLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => [
                'pl' => 'Senior PHP Developer',
                'en' => 'Senior PHP Developer',
            ],
        ]);
    }

    public function juniorLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'position' => [
                'pl' => 'Junior PHP Developer',
                'en' => 'Junior PHP Developer',
            ],
        ]);
    }
}
