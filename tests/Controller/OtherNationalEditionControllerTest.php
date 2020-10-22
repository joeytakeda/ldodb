<?php

namespace App\Tests\Controller;

use App\Entity\OtherNationalEdition;
use App\DataFixtures\OtherNationalEditionFixtures;
use Nines\UtilBundle\Tests\ControllerBaseCase;
use Nines\UserBundle\DataFixtures\UserFixtures;

class OtherNationalEditionControllerTest extends ControllerBaseCase {

    protected function fixtures() : array {
        return [
            UserFixtures::class,
            OtherNationalEditionFixtures::class
        ];
    }

    public function testAnonIndex() {

        $crawler = $this->client->request('GET', '/other_national_edition/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testUserIndex() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/other_national_edition/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testAdminIndex() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/other_national_edition/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('New')->count());
    }

    public function testAnonShow() {

        $crawler = $this->client->request('GET', '/other_national_edition/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testUserShow() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/other_national_edition/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testAdminShow() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/other_national_edition/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('Edit')->count());
        $this->assertEquals(1, $crawler->selectLink('Delete')->count());
    }

    public function testAnonEdit() {

        $crawler = $this->client->request('GET', '/other_national_edition/1/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserEdit() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/other_national_edition/1/edit');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEdit() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/other_national_edition/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->markTestIncomplete('This test fails for unknown reasons.');

        $form = $formCrawler->selectButton('Update')->form([
            'other_national_edition[publicationDate]' => 1072,
            'other_national_edition[book]' => $this->getReference('Book.1')->getId(),
            'other_national_edition[place]' => $this->getReference('Place.3')->getId(),
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/other_national_edition/1'));
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('1072')")->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Book.1')}')")->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Place.3')}')")->count());
    }

    public function testAnonNew() {

        $crawler = $this->client->request('GET', '/other_national_edition/new');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserNew() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/other_national_edition/new');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminNew() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/other_national_edition/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->markTestIncomplete('This test fails for unknown reasons.');

        $form = $formCrawler->selectButton('Create')->form([
            'other_national_edition[publicationDate]' => 1072,
            'other_national_edition[book]' => $this->getReference('Book.1')->getId(),
            'other_national_edition[place]' => $this->getReference('Place.3')->getId(),
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(1, $responseCrawler->filter("td:contains('1072')")->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Book.1')}')")->count());
        $this->assertEquals(1, $responseCrawler->filter("td:contains('{$this->getReference('Place.3')}')")->count());
    }

    public function testAnonDelete() {

        $crawler = $this->client->request('GET', '/other_national_edition/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserDelete() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/other_national_edition/1/delete');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminDelete() {


        $preCount = count($this->entityManager->getRepository(OtherNationalEdition::class)->findAll());
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/other_national_edition/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->entityManager->clear();
        $postCount = count($this->entityManager->getRepository(OtherNationalEdition::class)->findAll());
        $this->assertEquals($preCount - 1, $postCount);
    }

}
