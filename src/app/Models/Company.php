<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: Company
 *
 * Manages company/employer information:
 * - Stores basic company data (name, website)
 * - Used in experience/employment records
 * - Simple structure for employer reference
 *
 * Relations:
 * - hasMany Experience
 */
class Company extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'companies';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class, 'company_id');
    }

    // Accessors
    public function getFormattedUrlAttribute(): ?string
    {
        if (!$this->url) {
            return null;
        }

        $trimmedUrl = trim($this->url);

        return str_starts_with($trimmedUrl, 'http') ? $trimmedUrl : 'https://' . $trimmedUrl;
    }
}
