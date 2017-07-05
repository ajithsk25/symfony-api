<?php

namespace Ignitho\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageApiControllerTest extends WebTestCase
{
    public function testPostpage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/postPage');
    }

}
