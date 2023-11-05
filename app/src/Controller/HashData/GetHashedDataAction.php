<?php

declare(strict_types=1);

namespace App\Controller\HashData;

use App\Manager\Interface\HashDataManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/hash/{hashedValue}',
    name: self::class,
    methods: ['GET'],
)]
class GetHashedDataAction extends AbstractController
{
    public function __construct(private readonly HashDataManagerInterface $hashDataManager)
    {
    }

    public function __invoke(string $hashedValue): JsonResponse
    {
        return new JsonResponse($this->hashDataManager->getHashedData($hashedValue));
    }
}
