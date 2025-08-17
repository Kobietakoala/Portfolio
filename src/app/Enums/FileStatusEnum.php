<?php

declare(strict_types=1);

namespace App\Enums;

enum FileStatusEnum: int
{
    case PENDING = 0;
    case ACTIVE = 1;
    case ARCHIVED = 8;
    case DELETED = 9;

    public function label(): string
    {
        return __('enums.file_status.' . $this->value);
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isDeleted(): bool
    {
        return $this === self::DELETED;
    }

    public function isArchived(): bool
    {
        return $this === self::ARCHIVED;
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }
}
