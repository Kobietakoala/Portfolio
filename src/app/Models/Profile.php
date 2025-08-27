<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

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
}
