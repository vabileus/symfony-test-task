<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HashedDataRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: HashedDataRepository::class)]
class HashedData
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $data;

    #[ORM\Column(type: Types::TEXT)]
    private string $hashedData;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getHashedData(): string
    {
        return $this->hashedData;
    }

    public function setHashedData(string $hashedData): self
    {
        $this->hashedData = $hashedData;

        return $this;
    }
}
