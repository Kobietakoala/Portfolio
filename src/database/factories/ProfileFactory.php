<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\File;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

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
                'Software Engineer',
                'Technical Lead',
                'DevOps Engineer',
            ],
            'en' => [
                'Senior PHP Developer',
                'Full Stack Developer',
                'Backend Developer',
                'Software Engineer',
                'Technical Lead',
                'DevOps Engineer',
            ]
        ];

        return [
            'id' => Str::uuid(),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'position' => [
                'pl' => $this->faker->randomElement($positions['pl']),
                'en' => $this->faker->randomElement($positions['en']),
            ],
            'about' => [
                'pl' => $this->faker->paragraphs(3, true),
                'en' => $this->faker->paragraphs(3, true),
            ],
            'contact_description' => [
                'pl' => 'Skontaktuj się ze mną, aby omówić współpracę.',
                'en' => 'Contact me to discuss collaboration opportunities.',
            ],
            'mail' => $this->faker->unique()->safeEmail(),
            'avatar' => null,
            'github' => 'https://github.com/' . $this->faker->userName(),
        ];
    }

    /**
     * Indicate that the profile should have an avatar.
     */
    public function withAvatar(): static
    {
        return $this->afterCreating(function (Profile $profile) {
            $avatar = File::factory()->image()->create([
                'created_by' => $profile->id,
                'updated_by' => $profile->id,
            ]);

            $profile->update(['avatar' => $avatar->id]);
        });
    }

    /**
     * Create a profile without social links.
     */
    public function withoutSocial(): static
    {
        return $this->state(fn (array $attributes) => [
            'github' => null,
        ]);
    }
}
