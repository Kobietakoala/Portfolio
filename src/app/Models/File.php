<?php

namespace App\Models;

use App\Enums\FileStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: File
 *
 * Manages file metadata and storage information:
 * - Stores file information without actual file content
 * - Tracks file integrity via checksum
 * - Includes audit trail (created_by, updated_by)
 * - Supports various file statuses and sources
 *
 * Relations:
 * - belongsTo Profile (created_by)
 * - belongsTo Profile (updated_by)
 * - hasMany Profile (avatar)
 * - hasMany SkillCategory (logo)
 * - hasMany Skill (logo)
 */
class File extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'files';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'filename',
        'mime_type',
        'size',
        'checksum',
        'storage_key',
        'content_disposition',
        'source',
        'status',
        'metadata',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'size' => 'integer',
        'status' => 'integer',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => FileStatusEnum::ACTIVE,
    ];

    // Relations
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'updated_by');
    }

    // Reverse relations
    public function profilesAsAvatar(): HasMany
    {
        return $this->hasMany(Profile::class, 'avatar');
    }

    public function skillCategoriesAsLogo(): HasMany
    {
        return $this->hasMany(SkillCategory::class, 'logo');
    }

    public function skillsAsLogo(): HasMany
    {
        return $this->hasMany(Skill::class, 'logo');
    }

    // Accessors & Mutators
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
