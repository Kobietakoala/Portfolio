<?php

namespace App\Models;

use App\Service\ProfileService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
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
        'position' => 'array',
        'about' => 'array',
        'contact_description' => 'array',
    ];

    public array $translatable = [
        'position',
        'about',
        'contact_description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function avatarFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'avatar', 'id');
    }

    // Accessors
    public function getFullName(): string
    {
        return ucwords(trim($this->firstname . ' ' . $this->lastname));
    }

    public function getAvatar(): ?array
    {
        if (!$this->avatarFile) {
            return null;
        }

        return [
            'filename' => $this->avatarFile->filename,
            'url' => $this->avatarFile->getUrlAttribute(),
            'mime_type' => $this->avatarFile->mime_type,
        ];
    }

    /**
     * Boot model events
     */
    protected static function boot(): void
    {
        parent::boot();

        static::updated(static function () {
            ProfileService::clearProfileCache();
        });

        static::created(static function () {
            ProfileService::clearProfileCache();
        });

        static::deleted(static function () {
            ProfileService::clearProfileCache();
        });
    }


}
