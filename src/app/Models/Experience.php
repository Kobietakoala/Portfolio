<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * Model: Experience
 *
 * Manages work experience records with multilingual support:
 * - Links profiles with companies for employment history
 * - Supports multilingual position titles and descriptions
 * - Tracks employment periods with start/end dates
 * - Connected to skills through pivot table
 *
 * Relations:
 * - belongsTo Profile
 * - belongsTo Company
 * - belongsToMany Skill (through pivot table)
 */
class Experience extends Model
{
    use HasFactory, HasUuids, HasTranslations;

    protected $table = 'experience';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'profile_id',
        'company_id',
        'position',
        'description',
        'since',
        'until',
    ];

    protected $casts = [
        'since' => 'datetime',
        'until' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Translatable fields
    public array $translatable = [
        'position',
        'description',
    ];

    // Relations
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'experience_skills', 'experience_id', 'skill_id')
            ->withPivot(['focus_percent', 'notes'])
            ->withTimestamps();
    }

    // Accessors
    public function getDurationAttribute(): string
    {
        $start = $this->since;
        $end = $this->until ?? now();

        $diff = $start->diff($end);

        $years = $diff->y;
        $months = $diff->m;

        /** @TODO translations */
        if ($years > 0 && $months > 0) {
            return $years . ' lat, ' . $months . ' miesięcy';
        } elseif ($years > 0) {
            return $years . ' lat';
        } elseif ($months > 0) {
            return $months . ' miesięcy';
        } else {
            return 'Mniej niż miesiąc';
        }
    }

    public function getDurationInMonthsAttribute(): int
    {
        $start = $this->since;
        $end = $this->until ?? now();

        return $start->diffInMonths($end);
    }
}
