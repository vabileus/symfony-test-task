<?php

declare(strict_types=1);

namespace App\Mapping\Response;

use App\DTO\Response\SearchedDataDTO;
use App\Entity\HashedData;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\MappingOperation\Operation;

class HashedDataToSearchedDataDTOMapping implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(HashedData::class, SearchedDataDTO::class)
            ->forMember('item', Operation::fromProperty('data'));

    }
}
