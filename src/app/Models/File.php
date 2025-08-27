<?php

namespace App\Models;

use App\Enums\FileStatusEnum;
use App\Service\ProfileService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory, HasUuids;

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
        'status' => 'integer', // WAŻNE: rzutuj jako integer, nie jako enum
        'metadata' => 'array',
        'size' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Helper methods
    public function getStatusEnum(): FileStatusEnum
    {
        return FileStatusEnum::from($this->status);
    }

    public function isActive(): bool
    {
        return $this->status === FileStatusEnum::ACTIVE->value;
    }

    public function isDeleted(): bool
    {
        return $this->status === FileStatusEnum::DELETED->value;
    }

    public function isArchived(): bool
    {
        return $this->status === FileStatusEnum::ARCHIVED->value;
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->storage_key);
    }

    /**
     * Boot model events
     */
    protected static function boot(): void
    {
        parent::boot();

        static::updated(static function ($file) {
            $profilesUsingThisAsAvatar = Profile::where('avatar', $file->id)->exists();
            if ($profilesUsingThisAsAvatar) {
                Cache::forget(ProfileService::CACHE_KEY_PROFILE);
            }
        });

        static::deleted(static function ($file) {
            $profilesUsingThisAsAvatar = Profile::where('avatar', $file->id)->exists();
            if ($profilesUsingThisAsAvatar) {
                Cache::forget(ProfileService::CACHE_KEY_PROFILE);
            }
        });
    }

}
