<?php

declare(strict_types=1);

namespace App\Dictionary\Enum;

enum ResponseMessage: string
{
    case ALREADY_HASHED = 'This data value is already hashed';
}
