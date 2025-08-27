<?php

namespace App\Service;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ProfileService
{
    private const string CACHE_KEY_PROFILE = 'profile_data';
    private const int CACHE_TTL = 3600;

    public function __construct(
        private SkillService $skillService,
    ) { }

    public function getCachedProfileData(): ?array
    {
        return Cache::remember(self::CACHE_KEY_PROFILE, self::CACHE_TTL, function () {
            return $this->fetchProfileData();
        });
    }

    /**
     * @TODO remove
     * @return array|null
     */
    public function getProfileData(): ?array
    {
        return $this->fetchProfileData();
    }

    public static function clearProfileCache(): void
    {
        Cache::forget(self::CACHE_KEY_PROFILE);
    }

    private function fetchProfileData(): ?array
    {
        $user = User::with(['profile.avatarFile'])->first();

        if (!$user || !$user->profile) {
            return null;
        }

        /** @var Profile $profile */
        $profile = $user->profile;

        return [
            'cached_at' => now()->toISOString(),
            'cache_source' => 'database_fetch',
            'full_name' => $profile->getFullName(),
            'avatar' => $profile->getAvatar(),
            'position' => $profile->getAttribute('position'),
            'about' => $profile->getAttribute('about'),
            'contact_description' => $profile->getAttribute('contact_description'),
            'skills' => $this->skillService->getCategoriesWithSkills(),
            'experience' => $profile->getExperience(),
            'resume' => $profile->getResume(),
            'mail' => $profile->getAttribute('mail'),
            'github' => $profile->getAttribute('github'),
        ];
    }

}
