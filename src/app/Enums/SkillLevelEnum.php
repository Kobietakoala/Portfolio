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
        return match($this) {
            self::BEGINNER => 'Początkujący',
            self::INTERMEDIATE => 'Średniozaawansowany',
            self::ADVANCED => 'Zaawansowany',
            self::EXPERT => 'Ekspert',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}
