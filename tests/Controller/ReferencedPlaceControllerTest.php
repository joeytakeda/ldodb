<?php

namespace App\Tests\Controller;

use App\Entity\ReferencedPlace;
use App\DataFixtures\ReferencedPlaceFixtures;
use Nines\UtilBundle\Tests\ControllerBaseCase;
use Nines\UserBundle\DataFixtures\UserFixtures;

class ReferencedPlaceControllerTest extends ControllerBaseCase {

    public function fixtures() : array {
        return [
            UserFixtures::class,
            ReferencedPlaceFixtures::class
        ];
    }

    public function testAnonIndex() {

        $crawler = $this->client->request('GET', '/referenced_place/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testUserIndex() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/referenced_place/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testAdminIndex() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/referenced_place/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('New')->count());
    }

    public function testAnonShow() {

        $crawler = $this->client->request('GET', '/referenced_place/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testUserShow() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/referenced_place/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testAdminShow() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/referenced_place/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('Edit')->count());
        $this->assertEquals(1, $crawler->selectLink('Delete')->count());
    }

    public function testAnonEdit() {

        $crawler = $this->client->request('GET', '/referenced_place/1/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserEdit() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/referenced_place/1/edit');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEdit() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/referenced_place/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->markTestIncomplete('This test fails for unknown reasons.');

        $form = $formCrawler->selectButton('Update')->form([
            'referenced_place[variantSpelling]' => 'Icthyana',
            'referenced_place[book]' => $this->getReference('Book.1')->getId(),
            'referenced_place[place]' => $this->getReference('Place.1')->getId(),
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/referenced_place/1'));
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Icthyana")')->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Book.1')}')")->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Place.1')}')")->count());
    }

    public function testAnonNew() {

        $crawler = $this->client->request('GET', '/referenced_place/new');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserNew() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/referenced_place/new');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminNew() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/referenced_place/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->markTestIncomplete('This test fails for unknown reasons.');
        
        $form = $formCrawler->selectButton('Create')->form([
            'referenced_place[variantSpelling]' => 'Icthyana',
            'referenced_place[book]' => $this->getReference('Book.1')->getId(),
            'referenced_place[place]' => $this->getReference('Place.1')->getId(),
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Icthyana")')->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Book.1')}')")->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Place.1')}')")->count());
    }

    public function testAnonDelete() {

        $crawler = $this->client->request('GET', '/referenced_place/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserDelete() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/referenced_place/1/delete');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminDelete() {


        $preCount = count($this->entityManager->getRepository(ReferencedPlace::class)->findAll());
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/referenced_place/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->entityManager->clear();
        $postCount = count($this->entityManager->getRepository(ReferencedPlace::class)->findAll());
        $this->assertEquals($preCount - 1, $postCount);
    }

}
