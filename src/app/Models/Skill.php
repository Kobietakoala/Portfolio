<?php

namespace App\Models;

use App\Enums\SkillLevelEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * Model: Skill
 *
 * Manages individual skills with multilingual support:
 * - Supports multilingual skill names
 * - URL-friendly slug for web routing
 * - Optional logo/icon and proficiency level
 * - Categorized skills with mandatory category
 * - Used in experience-skill relationships
 *
 * Relations:
 * - belongsTo File (logo)
 * - belongsTo SkillCategory
 * - belongsToMany Experience (through pivot table)
 */
class Skill extends Model
{
    use HasFactory, HasUuids, HasTranslations;

    protected $table = 'skills';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'level',
        'category',
    ];

    protected $casts = [
        'level' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Translatable fields
    public array $translatable = [
        'name',
    ];

    // Relations
    public function logo(): BelongsTo
    {
        return $this->belongsTo(File::class, 'logo');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'category');
    }

    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Experience::class, 'experience_skills', 'skill_id', 'experience_id')
            ->withPivot(['focus_percent', 'notes'])
            ->withTimestamps();
    }

    // Accessors
    public function getLevelNameAttribute(): ?string
    {
        return match($this->level) {
            0 => 'Beginner',
            1 => 'Intermediate',
            2 => 'Advanced',
            3 => 'Expert',
            default => null,
        };
    }

    // Route model binding
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
