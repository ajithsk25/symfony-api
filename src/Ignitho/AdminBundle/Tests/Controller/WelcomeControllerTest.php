<?php

namespace Ignitho\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WelcomeControllerTest extends WebTestCase
{
    public function testFrontpage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

}
