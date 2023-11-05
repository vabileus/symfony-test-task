<?php

declare(strict_types=1);

namespace App\Mapping\Response;

use App\DTO\Response\HashedDataDTO;
use App\Entity\HashedData;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\MappingOperation\Operation;

class HashedDataToHashedDataDTOMapping implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(HashedData::class, HashedDataDTO::class)
            ->forMember('hash', Operation::fromProperty('hashedData'));
    }
}
