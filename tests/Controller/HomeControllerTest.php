<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/home');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenu');
    }
    public function testPageInexistante(): void
    {
        $client = static::createClient();
        $client->request('GET', '/pageerreur');

        $this->assertResponseStatusCodeSame(404);
    }
    public function testRedirection()
    {
        $client = static::createClient();
        $client->request('GET', '/home/test');
    }

    public function testRedirect(): void
    {
        $client = static::createClient();
        $client->request('GET', '/home/redirect');
        $this->assertResponseRedirects('/home');
    }
}
