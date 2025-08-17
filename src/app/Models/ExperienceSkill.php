<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: ExperienceSkill (Pivot)
 *
 * Manages many-to-many relationship between Experience and Skills:
 * - Links specific skills used in each work experience
 * - Tracks focus percentage (how much the skill was used)
 * - Optional notes for additional context
 * - Prevents duplicate skill assignments per experience
 *
 * Relations:
 * - belongsTo Experience
 * - belongsTo Skill
 */
class ExperienceSkill extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'experience_skills';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'experience_id',
        'skill_id',
        'focus_percent',
        'notes',
    ];

    protected $casts = [
        'focus_percent' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class, 'experience_id');
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    // Accessors
    public function getFocusLevelAttribute(): string
    {
        /** @TODO translations */
        return match(true) {
            $this->focus_percent >= 80 => 'Bardzo wysoki',
            $this->focus_percent >= 60 => 'Wysoki',
            $this->focus_percent >= 40 => 'Średni',
            $this->focus_percent >= 20 => 'Niski',
            default => 'Bardzo niski',
        };
    }
}
