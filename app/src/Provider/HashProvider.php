<?php

declare(strict_types=1);

namespace App\Provider;

class HashProvider
{
    public function hashData(string $data): string
    {
        return sha1($data);
    }
}
