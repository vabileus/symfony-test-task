<?php

declare(strict_types=1);

namespace App\Tests\TestCase\Controller\HashData;

use App\Fixtures\HashedDataFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GetHashedDataActionTest extends WebTestCase
{
    private const URL = '/hash/%s';

    private KernelBrowser $client;

    public function setUp(): void
    {
        $this->client = GetHashedDataActionTest::createClient();
        $container = $this->client->getContainer();
        $doctrine = $container->get('doctrine');
        $entityManager = $doctrine->getManager();

        $loader = new Loader();
        $loader->addFixture(new HashedDataFixtures());

        $purger = new ORMPurger($entityManager);
        $executor = new ORMExecutor($entityManager, $purger);
        $executor->execute($loader->getFixtures());

        parent::setUp();
    }

    /**
     * @dataProvider successOneItem
     */
    public function testGetOneItemAction(string $hash, string $expectedResult): void
    {
        $this->client->request('GET', sprintf(self::URL, $hash));

        $response = (array) json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertEquals($expectedResult, $response['item']);
    }

    /**
     * @dataProvider successOneItemWithCollisions
     */
    public function testGetItemWithCollisions(string $hash, string $expectedResult, string $expectedCollision): void
    {
        $this->client->request('GET', sprintf(self::URL, $hash));

        $response = (array) json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertEquals($expectedResult, $response['item']);
        $this->assertIsArray($response['collisions']);
        $this->assertEquals($expectedCollision, $response['collisions'][0]);
    }

    /**
     * @dataProvider getItemWithNotFoundError
     */
    public function testGetItemWithNotFoundError(string $hash): void
    {
        $this->client->request('GET', sprintf(self::URL, $hash));
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    public function getItemWithNotFoundError(): iterable
    {
        yield 'Get one item with not found error' => [
            'hash' => sha1('apple123')
        ];
    }

    public function successOneItem(): iterable
    {
        yield 'Success get one item' => [
            'hash' => sha1('apple'),
            'expectedResult' => 'apple'
        ];
    }

    public function successOneItemWithCollisions(): iterable
    {
        yield 'Success get item and collisions' => [
            'hash' => sha1('apple'),
            'expectedResult' => 'apple',
            'expectedCollision' => 'apple2'
        ];
    }
}
