<?php

declare(strict_types=1);

namespace App\DTO\Request;

use App\Utils\Trait\JsonSerializableTrait;
use Symfony\Component\Validator\Constraints as Assert;

class DataDTO implements \JsonSerializable
{
    use JsonSerializableTrait;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $data;
}
