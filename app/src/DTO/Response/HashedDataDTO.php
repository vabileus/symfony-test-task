<?php

declare(strict_types=1);

namespace App\DTO\Response;

use App\Utils\Trait\JsonSerializableTrait;

class HashedDataDTO implements \JsonSerializable
{
    use JsonSerializableTrait;

    public string $hash;

    public ?string $message;
}
