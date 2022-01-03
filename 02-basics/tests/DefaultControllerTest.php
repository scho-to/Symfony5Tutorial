<?php

namespace App\Tests;

use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    private $entityManager = null;
    private $client = null;

    protected function setUp() :void
    {
        self::ensureKernelShutdown();
        parent::setUp();
        $this->client = static::createClient();

        $this->entityManager = static::getContainer()->get("doctrine.orm.entity_manager");

        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }

    protected function tearDown(): void
    {
        $this->entityManager->rollback();
        $this->entityManager->close();
        $this->entityManager = null;
    }

    /**
     * @dataProvider provideUrls
     */
    public function testSomething($url): void
    {
        $crawler = $this->client->request('get', $url);

        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $video = $this->entityManager->getRepository(Video::class)->find(1);

        $this->entityManager->remove($video);
        $this->entityManager->flush();

        $this->assertNull($this->entityManager->getRepository(Video::class)->find(1));

    }

    public function provideUrls(): array
    {
        return [
            ['/home'],
            ['/login']
        ];
    }
}
