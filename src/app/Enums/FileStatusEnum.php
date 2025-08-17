<?php

declare(strict_types=1);


namespace App\Enums;

enum FileStatusEnum
{
    const int PENDING = 0;
    const int ACTIVE = 1;
    const int DELETED = 9;
}
