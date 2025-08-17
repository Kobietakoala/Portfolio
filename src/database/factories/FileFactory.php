<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\FileStatusEnum;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<File>
 */
class FileFactory extends Factory
{
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $extensions = ['png', 'pdf', 'txt'];
        $extension = $this->faker->randomElement($extensions);
        $filename = $this->faker->slug . '.' . $extension;

        $mimeTypes = [
            'png' => 'image/png',
            'pdf' => 'application/pdf',
            'txt' => 'text/plain',
        ];

        return [
            'id' => Str::uuid(),
            'filename' => $filename,
            'mime_type' => $mimeTypes[$extension],
            'size' => $this->faker->numberBetween(1024, 10485760), // 1KB - 10MB
            'checksum' => hash('sha256', $filename . time()),
            'storage_key' => 'files/' . date('Y/m/d') . '/' . Str::uuid() . '.' . $extension,
            'content_disposition' => $this->faker->randomElement(['inline', 'attachment']),
            'source' => $this->faker->randomElement(['upload', 'import', 'generated']),
            'status' => $this->faker->randomElement([
                FileStatusEnum::ACTIVE->value,
                FileStatusEnum::PENDING->value,
                FileStatusEnum::ARCHIVED->value,
                FileStatusEnum::DELETED->value
            ]),
            'metadata' => [
                'original_name' => $filename,
                'uploaded_by' => $this->faker->name(),
                'description' => $this->faker->optional()->sentence(),
            ],
            'created_by' => null,
            'updated_by' => null,
        ];
    }

    /**
     * Indicate that the file is an image.
     */
    public function image(): static
    {
        $extensions = ['png'];
        $extension = $this->faker->randomElement($extensions);
        $filename = $this->faker->slug . '.' . $extension;

        $mimeTypes = [
            'png' => 'image/png',
        ];

        return $this->state(fn (array $attributes) => [
            'filename' => $filename,
            'mime_type' => $mimeTypes[$extension],
            'content_disposition' => 'inline',
            'metadata' => array_merge($attributes['metadata'] ?? [], [
                'width' => $this->faker->numberBetween(100, 2000),
                'height' => $this->faker->numberBetween(100, 2000),
                'alt_text' => $this->faker->sentence(),
            ]),
        ]);
    }

    /**
     * Indicate that the file is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => FileStatusEnum::ARCHIVED->value,
        ]);
    }

    /**
     * Indicate that the file is deleted.
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => FileStatusEnum::DELETED->value,
        ]);
    }
}
