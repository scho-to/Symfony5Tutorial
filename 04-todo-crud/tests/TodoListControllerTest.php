<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoListControllerTest extends WebTestCase
{
    private $client = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    public function testController(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'My Todo List');
    }

    public function testPostSites(): void
    {
        $crawler = $this->client->request('GET', '/create');

        $this->assertResponseStatusCodeSame(405);
    }
}
