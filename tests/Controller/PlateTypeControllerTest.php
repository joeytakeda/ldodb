<?php

namespace App\Tests\Controller;

use App\Entity\PlateType;
use App\DataFixtures\PlateTypeFixtures;
use Nines\UtilBundle\Tests\ControllerBaseCase;
use Nines\UserBundle\DataFixtures\UserFixtures;

class PlateTypeControllerTest extends ControllerBaseCase {

    protected function fixtures() : array {
        return [
            UserFixtures::class,
            PlateTypeFixtures::class
        ];
    }

    public function testAnonIndex() {

        $crawler = $this->client->request('GET', '/plate_type/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testUserIndex() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/plate_type/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testAdminIndex() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/plate_type/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('New')->count());
    }

    public function testAnonShow() {

        $crawler = $this->client->request('GET', '/plate_type/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testUserShow() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/plate_type/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testAdminShow() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/plate_type/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('Edit')->count());
        $this->assertEquals(1, $crawler->selectLink('Delete')->count());
    }

    public function testAnonEdit() {

        $crawler = $this->client->request('GET', '/plate_type/1/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserEdit() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/plate_type/1/edit');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEdit() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/plate_type/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $formCrawler->selectButton('Update')->form([
            'plate_type[plateType]' => 'China',
            'plate_type[plateTypeNotes]' => 'Only for guests.',
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/plate_type/1'));
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("China")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Only for guests.")')->count());
    }

    public function testAnonNew() {

        $crawler = $this->client->request('GET', '/plate_type/new');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserNew() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/plate_type/new');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminNew() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/plate_type/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $formCrawler->selectButton('Create')->form([
            'plate_type[plateType]' => 'China',
            'plate_type[plateTypeNotes]' => 'Only for guests.',
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("China")')->count());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Only for guests.")')->count());
    }

    public function testAnonDelete() {

        $crawler = $this->client->request('GET', '/plate_type/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserDelete() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/plate_type/1/delete');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminDelete() {


        $preCount = count($this->entityManager->getRepository(PlateType::class)->findAll());
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/plate_type/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->entityManager->clear();
        $postCount = count($this->entityManager->getRepository(PlateType::class)->findAll());
        $this->assertEquals($preCount - 1, $postCount);
    }

}
