<?php

namespace App\Tests\Controller;

use App\Entity\SupplementalPlaceData;
use App\DataFixtures\SupplementalPlaceDataFixtures;
use Nines\UtilBundle\Tests\ControllerBaseCase;
use Nines\UserBundle\DataFixtures\UserFixtures;

class SupplementalPlaceDataControllerTest extends ControllerBaseCase {

    protected function fixtures() : array {
        return [
            UserFixtures::class,
            SupplementalPlaceDataFixtures::class
        ];
    }

    public function testAnonIndex() {

        $crawler = $this->client->request('GET', '/supplemental_place_data/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testUserIndex() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/supplemental_place_data/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testAdminIndex() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/supplemental_place_data/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('New')->count());
    }

    public function testAnonShow() {

        $crawler = $this->client->request('GET', '/supplemental_place_data/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testUserShow() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/supplemental_place_data/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testAdminShow() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/supplemental_place_data/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('Edit')->count());
        $this->assertEquals(1, $crawler->selectLink('Delete')->count());
    }

    public function testAnonEdit() {

        $crawler = $this->client->request('GET', '/supplemental_place_data/1/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserEdit() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/supplemental_place_data/1/edit');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEdit() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/supplemental_place_data/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $formCrawler->selectButton('Update')->form([
            'supplemental_place_data[geonameId]' => '120',
            'supplemental_place_data[geoname]' => 'Catfish Creek',
            'supplemental_place_data[latitude]' => 12.4,
            'supplemental_place_data[longitude]' => 13.4,
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/supplemental_place_data/1'));
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("120")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Catfish Creek")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("12.4")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("13.4")')->count());
    }

    public function testAnonNew() {

        $crawler = $this->client->request('GET', '/supplemental_place_data/new');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserNew() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/supplemental_place_data/new');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminNew() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/supplemental_place_data/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $formCrawler->selectButton('Create')->form([
            'supplemental_place_data[geonameId]' => '120',
            'supplemental_place_data[geoname]' => 'Catfish Creek',
            'supplemental_place_data[latitude]' => 12.4,
            'supplemental_place_data[longitude]' => 13.4,
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("120")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Catfish Creek")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("12.4")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("13.4")')->count());
    }

    public function testAnonDelete() {

        $crawler = $this->client->request('GET', '/supplemental_place_data/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserDelete() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/supplemental_place_data/1/delete');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminDelete() {


        $preCount = count($this->entityManager->getRepository(SupplementalPlaceData::class)->findAll());
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/supplemental_place_data/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->entityManager->clear();
        $postCount = count($this->entityManager->getRepository(SupplementalPlaceData::class)->findAll());
        $this->assertEquals($preCount - 1, $postCount);
    }

}
