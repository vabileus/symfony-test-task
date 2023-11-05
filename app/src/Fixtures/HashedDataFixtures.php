<?php

namespace App\Fixtures;

use App\Entity\HashedData;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HashedDataFixtures extends Fixture
{
    private const ITEM = 'apple';
    private const ITEM_COLLISION = 'apple2';

    public function load(ObjectManager $manager): void
    {
        $hashedData = new HashedData();
        $hashedData->setData(self::ITEM);
        $hashedData->setHashedData(sha1(self::ITEM));

        $hashedDataCollision = new HashedData();
        $hashedDataCollision->setData(self::ITEM_COLLISION);
        $hashedDataCollision->setHashedData(sha1(self::ITEM));

        $manager->persist($hashedData);
        $manager->persist($hashedDataCollision);
        $manager->flush();
    }
}
