<?php

namespace App\Tests\Controller;

use App\Entity\DigitalCopyHolder;
use App\DataFixtures\DigitalCopyHolderFixtures;
use Nines\UtilBundle\Tests\ControllerBaseCase;
use Nines\UserBundle\DataFixtures\UserFixtures;

class DigitalCopyHolderControllerTest extends ControllerBaseCase {

    protected function fixtures() : array {
        return [
            UserFixtures::class,
            DigitalCopyHolderFixtures::class
        ];
    }

    public function testAnonIndex() {

        $crawler = $this->client->request('GET', '/digital_copy_holder/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testUserIndex() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/digital_copy_holder/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('New')->count());
    }

    public function testAdminIndex() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/digital_copy_holder/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('New')->count());
    }

    public function testAnonShow() {

        $crawler = $this->client->request('GET', '/digital_copy_holder/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testUserShow() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/digital_copy_holder/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(0, $crawler->selectLink('Edit')->count());
        $this->assertEquals(0, $crawler->selectLink('Delete')->count());
    }

    public function testAdminShow() {
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/digital_copy_holder/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->selectLink('Edit')->count());
        $this->assertEquals(1, $crawler->selectLink('Delete')->count());
    }

    public function testAnonEdit() {

        $crawler = $this->client->request('GET', '/digital_copy_holder/1/edit');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserEdit() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/digital_copy_holder/1/edit');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminEdit() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/digital_copy_holder/1/edit');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $formCrawler->selectButton('Update')->form([
            'digital_copy_holder[organizationName]' => 'Jimbos Fishing Thing',
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect('/digital_copy_holder/1'));
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Jimbos Fishing Thing")')->count());
    }

    public function testAnonNew() {

        $crawler = $this->client->request('GET', '/digital_copy_holder/new');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserNew() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/digital_copy_holder/new');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminNew() {
        $this->login('user.admin');
        $formCrawler = $this->client->request('GET', '/digital_copy_holder/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $form = $formCrawler->selectButton('Create')->form([
            'digital_copy_holder[organizationName]' => 'Jimbos Fishing Thing',
        ]);

        $this->client->submit($form);
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertEquals(1, $responseCrawler->filter('td:contains("Jimbos Fishing Thing")')->count());
    }

    public function testAnonDelete() {

        $crawler = $this->client->request('GET', '/digital_copy_holder/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testUserDelete() {
        $this->login('user.user');
        $crawler = $this->client->request('GET', '/digital_copy_holder/1/delete');
        $this->assertEquals(403, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminDelete() {


        $preCount = count($this->entityManager->getRepository(DigitalCopyHolder::class)->findAll());
        $this->login('user.admin');
        $crawler = $this->client->request('GET', '/digital_copy_holder/1/delete');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect());
        $responseCrawler = $this->client->followRedirect();
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->entityManager->clear();
        $postCount = count($this->entityManager->getRepository(DigitalCopyHolder::class)->findAll());
        $this->assertEquals($preCount - 1, $postCount);
    }

}
