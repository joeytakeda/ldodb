<?php

namespace Tests\App\Controller;

use Nines\UtilBundle\Tests\ControllerBaseCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends ControllerBaseCase {

    public function testIndex() {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

}
