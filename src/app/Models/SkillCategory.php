<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * Model: SkillCategory
 *
 * Manages skill categories for organizing skills:
 * - Supports multilingual category names
 * - Optional logo/icon for visual representation
 * - Groups related skills together
 * - Categories like "Programming Languages", "Frameworks", etc.
 *
 * Relations:
 * - belongsTo File (logo)
 * - hasMany Skill
 */
class SkillCategory extends Model
{
    use HasFactory, HasUuids, HasTranslations;

    protected $table = 'skill_categories';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'logo',
    ];

    protected $casts = [
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

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class, 'category');
    }

    public function getSkillsName(): array
    {
        return $this->skills->map(function($skill) {
            if (is_array($skill->name)) {
                return $skill->getTranslation('name', app()->getLocale());
            }
            return $skill->name;
        })->values()->toArray();
    }

    public function getNameAttribute($value): string
    {
        if (is_array($value)) {
            $translation = $this->getTranslation('name', app()->getLocale());
            if (!empty($translation)) {
                return $translation;
            }

            return !empty($value['en']) ? $value['en'] : 'N/A';
        }
        return !empty($value) ? $value : 'N/A';
    }

}
