<?php

declare(strict_types=1);

namespace App\Manager\Decorator;

use App\Dictionary\Enum\ResponseMessage;
use App\DTO\Request\DataDTO;
use App\DTO\Response\HashedDataDTO;
use App\DTO\Response\HashedDataDTO as ResponseHashedDataDTO;
use App\Manager\Interface\HashDataManagerInterface;
use App\Manager\HashDataManager;
use App\Provider\HashProvider;
use App\Repository\HashedDataRepository;
use AutoMapperPlus\AutoMapperInterface;
use AutoMapperPlus\Exception\UnregisteredMappingException;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use App\DTO\Response\SearchedDataDTO as ResponseSearchedDataDTO;

#[AsDecorator(decorates: HashDataManager::class)]
class HashDataManagerDecorator implements HashDataManagerInterface
{
    private object $inner;

    public function __construct(
        #[AutowireDecorated]
        object $inner,
        private readonly HashedDataRepository $hashedDataRepository,
        private readonly HashProvider $hashProvider,
        private readonly AutoMapperInterface $mapper
    ) {
        $this->inner = $inner;
    }
    public function getHashedData(string $hash): ResponseSearchedDataDTO
    {
        return $this->inner->getHashedData($hash);
    }

    /**
     * @throws UnregisteredMappingException
     */
    public function createHashData(DataDTO $dataDTO): ResponseHashedDataDTO
    {
        $hashedValue = $this->hashedDataRepository->findOneByHashedData($this->hashProvider->hashData($dataDTO->data));

        if ($hashedValue) {
            /** @var HashedDataDTO $responseHashedDataDTO */
            $responseHashedDataDTO = $this->mapper->map($hashedValue, HashedDataDTO::class);
            $responseHashedDataDTO->message = ResponseMessage::ALREADY_HASHED->value;

            return $responseHashedDataDTO;
        }

        return $this->inner->createHashData($dataDTO);
    }
}
