<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public function testSomething($url): void
    {
        $client = static::createClient();
        $crawler = $client->request('get', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());

    }

    public function provideUrls()
    {
        return [
            ['/home'],
            ['/login']
        ];
    }
}
