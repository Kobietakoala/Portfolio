<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\File;
use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<SkillCategory>
 */
class SkillCategoryFactory extends Factory
{
    protected $model = SkillCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            [
                'pl' => 'Języki programowania',
                'en' => 'Programming Languages',
            ],
            [
                'pl' => 'Frameworki',
                'en' => 'Frameworks',
            ],
            [
                'pl' => 'Bazy danych',
                'en' => 'Databases',
            ],
            [
                'pl' => 'Narzędzia DevOps',
                'en' => 'DevOps Tools',
            ],
            [
                'pl' => 'Frontend',
                'en' => 'Frontend Technologies',
            ],
            [
                'pl' => 'Backend',
                'en' => 'Backend Technologies',
            ],
            [
                'pl' => 'Usługi chmurowe',
                'en' => 'Cloud Services',
            ],
            [
                'pl' => 'Systemy operacyjne',
                'en' => 'Operating Systems',
            ],
        ];

        $category = $this->faker->randomElement($categories);

        return [
            'id' => Str::uuid(),
            'name' => $category,
            'logo' => null,
        ];
    }

    /**
     * Create predefined skill categories.
     */
    public function predefined(): static
    {
        return $this->sequence(
            ['name' => ['pl' => 'Języki programowania', 'en' => 'Programming Languages']],
            ['name' => ['pl' => 'Frameworki', 'en' => 'Frameworks']],
            ['name' => ['pl' => 'Bazy danych', 'en' => 'Databases']],
            ['name' => ['pl' => 'Narzędzia DevOps', 'en' => 'DevOps Tools']],
            ['name' => ['pl' => 'Frontend', 'en' => 'Frontend Technologies']],
            ['name' => ['pl' => 'Backend', 'en' => 'Backend Technologies']],
            ['name' => ['pl' => 'Usługi chmurowe', 'en' => 'Cloud Services']],
            ['name' => ['pl' => 'Systemy operacyjne', 'en' => 'Operating Systems']],
        );
    }

    /**
     * Create a category with logo.
     */
    public function withLogo(): static
    {
        return $this->afterCreating(function (SkillCategory $category) {
            $logo = File::factory()->image()->create();
            $category->update(['logo' => $logo->id]);
        });
    }
}
