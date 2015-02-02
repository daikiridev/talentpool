<?php

namespace TEW\TPBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TPControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tp/hello/Fabien');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello Fabien")')->count());
    }
}
