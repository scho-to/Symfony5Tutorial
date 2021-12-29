<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');
        $link = null;

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello');

        $link = $crawler->filter("a:contains('Have an account?')")->link();
        $crawler = $client->click($link);

        $this->assertStringContainsString("Keep me logged in", $client->getResponse()->getContent());
    }
}
