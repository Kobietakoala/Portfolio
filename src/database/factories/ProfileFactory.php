<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(), // Automatycznie tworzy użytkownika
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'position' => [
                'pl' => fake()->randomElement([
                    'Software Engineer', 'DevOps Engineer', 'Full Stack Developer',
                    'Frontend Developer', 'Backend Developer', 'UI/UX Designer'
                ]),
                'en' => fake()->randomElement([
                    'Software Engineer', 'DevOps Engineer', 'Full Stack Developer',
                    'Frontend Developer', 'Backend Developer', 'UI/UX Designer'
                ])
            ],
            'about' => [
                'pl' => fake('pl_PL')->paragraphs(3, true),
                'en' => fake()->paragraphs(3, true)
            ],
            'contact_description' => [
                'pl' => 'Skontaktuj się ze mną, aby omówić współpracę.',
                'en' => 'Contact me to discuss collaboration opportunities.'
            ],
            'mail' => fake()->unique()->safeEmail(),
            'avatar' => null, // Będzie ustawione w seeder jeśli potrzeba
            'github' => fake()->url(),
        ];
    }

    /**
     * State for specific user
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
            'mail' => $user->email, // Używamy email użytkownika
        ]);
    }
}
