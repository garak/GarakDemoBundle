<?php

namespace Garak\DemoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertEquals(12, $crawler->filter('div#products ul li')->count());
    }

    public function testAdd()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/');
        $link = $crawler->filter('div#products ul li a')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div#cart ul li')->count());
    }

    public function testRemove()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/');
        $link = $crawler->filter('div#products ul li a')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $link = $crawler->filter('div#cart ul li a.remove')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(0, $crawler->filter('div#cart ul li')->count());
    }

    public function testIncrease()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/');
        $link = $crawler->filter('div#products ul li a')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div#cart span.quantity:contains("1")')->count());
        $link = $crawler->filter('div#cart ul li a.increase')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div#cart ul li')->count());
        $this->assertEquals(1, $crawler->filter('div#cart span.quantity:contains("2")')->count());
    }

    public function testDecrease()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/');
        $link = $crawler->filter('div#products ul li a')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div#cart span.quantity:contains("1")')->count());
        $link = $crawler->filter('div#cart ul li a.increase')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div#cart ul li')->count());
        $this->assertEquals(1, $crawler->filter('div#cart span.quantity:contains("2")')->count());
        $link = $crawler->filter('div#cart ul li a.decrease')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('div#cart span.quantity:contains("1")')->count());
    }
    
    public function testEmpty()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/demo/');
        $link = $crawler->filter('div#products ul li a')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $link = $crawler->filter('div#products ul li a')->eq(2)->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(2, $crawler->filter('div#cart ul li')->count());
        $link = $crawler->filter('a#empty_cart')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertEquals(0, $crawler->filter('div#cart ul li')->count());
    }
}
