<?php

declare(strict_types=1);

namespace App\DTO\Response;

use App\Utils\Trait\JsonSerializableTrait;

class SearchedDataDTO implements \JsonSerializable
{
    use JsonSerializableTrait;

    public string $item;

    /** @var string[] $collisions */
    public array $collisions;
}
