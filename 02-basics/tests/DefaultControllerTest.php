<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $link = null;

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(1, $crawler->filter("label:contains('Email:')")->count());
        $this->assertEquals(1, $crawler->filter("form")->count());

        $form = $crawler->selectButton("login")->form();
        $form['email'] = "user@user.com";
        $form["password"] = "passw";

        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirection());
        $crawler = $client->followRedirect();

        $this->assertEquals(1, $crawler->filter('a:contains("Logout")')->count());



        // $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h1', 'Hello');

        // $link = $crawler->filter("a:contains('Have an account?')")->link();
        // $crawler = $client->click($link);

        // $this->assertStringContainsString("Keep me logged in", $client->getResponse()->getContent());
    }
}
