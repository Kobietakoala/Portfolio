<?php

namespace App\Service;

use Illuminate\Support\Facades\Cache;

class ProfileService
{
    private const string CACHE_KEY_PROFILE = 'profile_data';
    private const int CACHE_TTL = 3600;

    public function getProfileData(): ?array
    {
        return Cache::remember(self::CACHE_KEY_PROFILE, self::CACHE_TTL, function () {
            return $this->fetchProfileData();
        });
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

        $profile = $user->profile;

        return [
            'cached_at' => now()->toISOString(),
            'cache_source' => 'database_fetch',
            'full_name' => $profile->getFullName(),
            'avatar' => $profile->getAvatar(),
            'about' => $profile->about,
        ];
    }

}
