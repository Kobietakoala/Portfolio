<?php

namespace App\Models;

use App\Service\ProfileService;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class, 'profile_id');
    }

    public function resumeFile(): HasOne
    {
        $locale = app()->getLocale();

        return $this->hasOne(File::class, 'id', 'id')
            ->where('filename', 'like', 'resume_' . $locale . '%')
            ->ofMany('created_at', 'max');
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

    public function getExperience(): array
    {
        $experiences = $this->experiences()
            ->with([
                'company',
                'skills' => function($query) {
                    $query->orderBy('name->pl');
                }
            ])
            ->orderBy('since', 'desc')
            ->get();

        if ($experiences->isEmpty()) {
            return [];
        }

        $result = [];

        /** @var Experience $experience */
        foreach ($experiences as $experience) {
            $companyName = $experience->company->name ?? 'Nieznana firma';

            if (isset($result[$companyName])) {
                $result[$companyName][] = [
                    'position' => $experience->getPosition(),
                    'link' => $experience->company->website ?? null,
                    'date' => $experience->getDateRange(),
                    'description' => $experience->getDescription(),
                    'skills' => $experience->getSkills(),
                ];
            } else {
                $result[$companyName] = [[
                    'position' =>$experience->getPosition(),
                    'link' => $experience->company->website ?? null,
                    'date' => $experience->getDateRange(),
                    'description' => $experience->getDescription(),
                    'skills' => $experience->getSkills(),
                ]];
            }
        }

        return $result;
    }

    public function getResume(): ?array
    {
        if (!$this->resumeFile) {
            return null;
        }

        return [
            'filename' => $this->resumeFile->filename,
            'url' => $this->resumeFile->getUrlAttribute(),
            'mime_type' => $this->resumeFile->mime_type,
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
