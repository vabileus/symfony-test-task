<?php

declare(strict_types=1);

namespace App\Manager;

use App\DTO\Request\DataDTO;
use App\DTO\Response\HashedDataDTO as ResponseHashedDataDTO;
use App\Entity\HashedData;
use App\Manager\Interface\HashDataManagerInterface;
use App\Provider\HashProvider;
use App\Repository\HashedDataRepository;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\DTO\Response\SearchedDataDTO as ResponseSearchedDataDTO;

#[AsAlias(id: HashDataManagerInterface::class, public: true)]
class HashDataManager implements HashDataManagerInterface
{
    public function __construct(
        private readonly HashedDataRepository $hashedDataRepository,
        private readonly AutoMapperInterface $mapper,
        private readonly HashProvider $hashProvider
    ) {
    }

    /**
     * @throws UnregisteredMappingException
     */
    public function getHashedData(string $hash): ResponseSearchedDataDTO
    {
        $hashEntries = $this->hashedDataRepository->findByHash($hash);

        if (empty($hashEntries)) {
            throw new NotFoundHttpException('No hashed values was found');
        }

        if (count($hashEntries) === 1) {
            return $this->mapper->map($hashEntries[0], ResponseSearchedDataDTO::class);
        }

        return $this->mapper->map($hashEntries, ResponseSearchedDataDTO::class);
    }

    /**
     * @throws UnregisteredMappingException
     */
    public function createHashData(DataDTO $dataDTO): ResponseHashedDataDTO
    {
        /** @var HashedData $hashedData */
        $hashedData = $this->mapper->map($dataDTO, HashedData::class);
        $hashedData->setHashedData($this->hashProvider->hashData($dataDTO->data));

        $this->hashedDataRepository->save($hashedData, true);

        return $this->mapper->map($hashedData, ResponseHashedDataDTO::class);
    }
}