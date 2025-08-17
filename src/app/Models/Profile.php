<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * Model: Profile
 *
 * Manages user profile information with multilingual support:
 * - Stores personal and professional information
 * - Supports multiple languages via JSON fields
 * - Links to avatar files
 * - Contains contact information and social links
 *
 * Relations:
 * - belongsTo File (avatar)
 * - hasMany Experience
 * - hasMany File (created files)
 * - hasMany File (updated files)
 */
class Profile extends Model
{
    use HasFactory, HasUuids, HasTranslations;

    protected $table = 'profiles';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'firstname',
        'lastname',
        'position',
        'about',
        'contact_description',
        'mail',
        'avatar',
        'github',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Translatable fields
    public array $translatable = [
        'position',
        'about',
        'contact_description',
    ];

    // Relations
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(File::class, 'avatar');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class, 'profile_id');
    }

    public function createdFiles(): HasMany
    {
        return $this->hasMany(File::class, 'created_by');
    }

    public function updatedFiles(): HasMany
    {
        return $this->hasMany(File::class, 'updated_by');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    public function getInitialsAttribute(): string
    {
        $firstname = $this->firstname ?? '';
        $lastname = $this->lastname ?? '';

        return strtoupper(
            substr($firstname, 0, 1) . substr($lastname, 0, 1)
        );
    }
}
