<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Experience;
use App\Models\ExperienceSkill;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ExperienceSkill>
 */
class ExperienceSkillFactory extends Factory
{
    protected $model = ExperienceSkill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $notes = [
            'Główna technologia używana w projekcie',
            'Wykorzystywana do integracji z API',
            'Używana sporadycznie w projektach',
            'Technologia wspierająca',
            'Intensive use for data processing',
            'Primary database solution',
            'Used for frontend development',
            'Essential for deployment processes',
            'Critical for performance optimization',
            'Supporting technology stack',
        ];

        return [
            'id' => Str::uuid(),
            'experience_id' => Experience::factory(),
            'skill_id' => Skill::factory(),
            'focus_percent' => $this->faker->numberBetween(10, 95),
            'notes' => $this->faker->optional(0.7)->randomElement($notes),
        ];
    }

    /**
     * Create a high focus skill (80%+).
     */
    public function highFocus(): static
    {
        return $this->state(fn (array $attributes) => [
            'focus_percent' => $this->faker->numberBetween(80, 95),
            'notes' => 'Główna technologia używana w projekcie',
        ]);
    }

    /**
     * Create a medium focus skill (40-70%).
     */
    public function mediumFocus(): static
    {
        return $this->state(fn (array $attributes) => [
            'focus_percent' => $this->faker->numberBetween(40, 70),
            'notes' => 'Technologia wspierająca w projekcie',
        ]);
    }

    /**
     * Create a low focus skill (10-30%).
     */
    public function lowFocus(): static
    {
        return $this->state(fn (array $attributes) => [
            'focus_percent' => $this->faker->numberBetween(10, 30),
            'notes' => 'Używana sporadycznie',
        ]);
    }

    /**
     * Create without notes.
     */
    public function withoutNotes(): static
    {
        return $this->state(fn (array $attributes) => [
            'notes' => null,
        ]);
    }
}
