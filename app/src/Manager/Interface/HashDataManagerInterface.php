<?php

declare(strict_types=1);

namespace App\Manager\Interface;

use App\DTO\Request\DataDTO;
use App\DTO\Response\HashedDataDTO as ResponseHashedDataDTO;
use App\DTO\Response\SearchedDataDTO as ResponseSearchedDataDTO;

interface HashDataManagerInterface
{
    public function getHashedData(string $hash): ResponseSearchedDataDTO;

    public function createHashData(DataDTO $dataDTO): ResponseHashedDataDTO;
}
