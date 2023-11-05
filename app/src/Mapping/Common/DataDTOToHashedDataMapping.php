<?php

declare(strict_types=1);

namespace App\Mapping\Common;

use App\DTO\Request\DataDTO;
use App\Entity\HashedData;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\MappingOperation\Operation;

class DataDTOToHashedDataMapping implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(DataDTO::class, HashedData::class)
            ->forMember('data', Operation::fromProperty('data'));
    }
}
