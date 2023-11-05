<?php

declare(strict_types=1);

namespace App\Controller\HashData;

use App\DTO\Request\DataDTO;
use App\Manager\Interface\HashDataManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route(
    path: '/hash',
    name: self::class,
    methods: ['POST'],
)]
class CreateHashedDataAction extends AbstractController
{
    public function __construct(private readonly HashDataManagerInterface $hashDataManager)
    {
    }

    public function __invoke(
        #[MapRequestPayload] DataDTO $dataDTO
    ): JsonResponse {
        return new JsonResponse($this->hashDataManager->createHashData($dataDTO));
    }
}
