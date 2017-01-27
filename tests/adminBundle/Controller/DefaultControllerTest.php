<?php

namespace adminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/public/accueil');//on se place sur la route / racine

        //Il faurt mettre à jour le contenu de la page.

        $container = $client->getContainer();//On a accès à tous les services symfony

        //Le crowler sert à filtrer les données du site et ainsi vérifier la présence d'éléments

        $this->assertContains('MusicStore', $crawler->filter('.container .navbar-header .navbar-brand')->text());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertGreaterThan(0, $crawler->filter('.navbar-collapse ul li')->count());

        $link = $crawler->selectLink('Products')->link();

        $crawler = $client->click($link);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Ceci est le titre de ma page', $crawler->filter('.container')->text());

        //dump($crawler);
    }
}
