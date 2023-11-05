<?php

declare(strict_types=1);

namespace App\Mapping\Response;

use App\DTO\Response\SearchedDataDTO;
use App\Entity\HashedData;
use AutoMapperPlus\AutoMapperPlusBundle\AutoMapperConfiguratorInterface;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use AutoMapperPlus\DataType;

class ArrayToSearchedDataDTOMapping implements AutoMapperConfiguratorInterface
{
    public function configure(AutoMapperConfigInterface $config): void
    {
        $config->registerMapping(DataType::ARRAY, SearchedDataDTO::class)
            ->forMember(
                targetPropertyName: 'item',
                operation: static fn(array $data): string => $data[0]->getData()
            )
            ->forMember(
                targetPropertyName: 'collisions',
                operation: static fn(array $data): array => array_map(fn(HashedData $value): string => $value->getData(), array_slice($data, 1)))
        ;
    }
}
