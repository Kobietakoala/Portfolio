<?php

declare(strict_types=1);

namespace App\Enums;

enum SkillLevelEnum: int
{
    case BEGINNER = 0;
    case INTERMEDIATE = 1;
    case ADVANCED = 2;
    case EXPERT = 3;

    public function label(): string
    {
        return __('enums.skill_level.' . $this->value);
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
