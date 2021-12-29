<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/home');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello');

        $this->assertGreaterThan(
            0,
            $crawler->filter("html:contains('Hello')")->count()
        );
        // $this->assertGreaterThan(0, $crawler->filter("h1.class")->count());
        $this->assertCount(1,$crawler->filter("h1"));
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"'
        );
        $this->assertStringContainsString("DefaultController", $client->getResponse()->getContent());
        $this->assertMatchesRegularExpression('/foo(bar)?/', $client->getResponse()->getContent());
        $this->assertTrue($client->getResponse()->isSuccessful(), "response status i 2xx");
        $this->assertTrue($client->getResponse()->isNotFound());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(
            $client->getResponse()->isRedirect("/demo/contact")
        );
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
