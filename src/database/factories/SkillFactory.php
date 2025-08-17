<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\File;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = [
            ['name' => ['pl' => 'PHP', 'en' => 'PHP'], 'slug' => 'php'],
            ['name' => ['pl' => 'Laravel', 'en' => 'Laravel'], 'slug' => 'laravel'],
            ['name' => ['pl' => 'JavaScript', 'en' => 'JavaScript'], 'slug' => 'javascript'],
            ['name' => ['pl' => 'Vue.js', 'en' => 'Vue.js'], 'slug' => 'vuejs'],
            ['name' => ['pl' => 'React', 'en' => 'React'], 'slug' => 'react'],
            ['name' => ['pl' => 'MySQL', 'en' => 'MySQL'], 'slug' => 'mysql'],
            ['name' => ['pl' => 'PostgreSQL', 'en' => 'PostgreSQL'], 'slug' => 'postgresql'],
            ['name' => ['pl' => 'Docker', 'en' => 'Docker'], 'slug' => 'docker'],
            ['name' => ['pl' => 'Git', 'en' => 'Git'], 'slug' => 'git'],
            ['name' => ['pl' => 'Linux', 'en' => 'Linux'], 'slug' => 'linux'],
        ];

        $skill = $this->faker->randomElement($skills);

        return [
            'id' => Str::uuid(),
            'name' => $skill['name'],
            'slug' => $skill['slug'],
            'logo' => null,
            'level' => $this->faker->numberBetween(0, 3),
            'category' => SkillCategory::factory(),
        ];
    }

    /**
     * Create predefined skills for programming languages category.
     */
    public function programmingLanguages(): static
    {
        return $this->sequence(
            [
                'name' => ['pl' => 'PHP', 'en' => 'PHP'],
                'slug' => 'php',
                'level' => 3,
            ],
            [
                'name' => ['pl' => 'JavaScript', 'en' => 'JavaScript'],
                'slug' => 'javascript',
                'level' => 2,
            ],
            [
                'name' => ['pl' => 'Python', 'en' => 'Python'],
                'slug' => 'python',
                'level' => 1,
            ],
            [
                'name' => ['pl' => 'TypeScript', 'en' => 'TypeScript'],
                'slug' => 'typescript',
                'level' => 2,
            ],
        );
    }

    /**
     * Create predefined skills for frameworks category.
     */
    public function frameworks(): static
    {
        return $this->sequence(
            [
                'name' => ['pl' => 'Laravel', 'en' => 'Laravel'],
                'slug' => 'laravel',
                'level' => 3,
            ],
            [
                'name' => ['pl' => 'Vue.js', 'en' => 'Vue.js'],
                'slug' => 'vuejs',
                'level' => 2,
            ],
            [
                'name' => ['pl' => 'React', 'en' => 'React'],
                'slug' => 'react',
                'level' => 1,
            ],
            [
                'name' => ['pl' => 'Symfony', 'en' => 'Symfony'],
                'slug' => 'symfony',
                'level' => 2,
            ],
        );
    }

    /**
     * Create a skill with logo.
     */
    public function withLogo(): static
    {
        return $this->afterCreating(function (Skill $skill) {
            $logo = File::factory()->image()->create();
            $skill->update(['logo' => $logo->id]);
        });
    }

    /**
     * Create an expert level skill.
     */
    public function expert(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 3,
        ]);
    }

    /**
     * Create a beginner level skill.
     */
    public function beginner(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 0,
        ]);
    }
}
