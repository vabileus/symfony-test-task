<?php

declare(strict_types=1);

namespace App\Tests\TestCase\Controller\HashData;

use App\Dictionary\Enum\ResponseMessage;
use App\Fixtures\HashedDataFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CreateHashedDataActionTest extends WebTestCase
{
    private const URL = '/hash';

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
     * @dataProvider successCreation
     */
    public function testCreateAction(string $data, string $expectedResult): void
    {
        $this->client->request('POST', self::URL,
            [
                'data' => $data
            ]
        );

        $response = (array) json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertEquals($expectedResult, $response['hash']);
    }

    /**
     * @dataProvider successCreationWithMessage
     */
    public function testCreateActionWithMessage(string $data, string $expectedResult): void
    {
        $this->client->request('POST', self::URL,
            [
                'data' => $data
            ]
        );

        $response = (array) json_decode($this->client->getResponse()->getContent());

        $this->assertResponseIsSuccessful();
        $this->assertEquals($expectedResult, $response['hash']);
        $this->assertNotNull($response['message']);
        $this->assertEquals(ResponseMessage::ALREADY_HASHED->value, $response['message']);
    }

    /**
     * @dataProvider validationError
     */
    public function testGetItemWithNotFoundError(?string $data): void
    {
        $this->client->request('POST', self::URL,
            [
                'data' => $data
            ]
        );

        $this->assertEquals(422, $this->client->getResponse()->getStatusCode());
    }

    public function validationError(): iterable
    {
        yield 'Creation with validation error' => [
            'data' => null
        ];
    }

    public function successCreationWithMessage(): iterable
    {
        yield 'Success create hashed data (with same data) with validation message' => [
            'data' => 'apple',
            'expectedResult' => sha1('apple')
        ];
    }

    public function successCreation(): iterable
    {
        yield 'Success create hashed data' => [
            'data' => 'apple',
            'expectedResult' => sha1('apple')
        ];
    }
}
