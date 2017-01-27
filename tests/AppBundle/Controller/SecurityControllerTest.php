<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 27/01/17
 * Time: 12:20
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testSignin(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/signin');
        $container = $client->getContainer();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $username = 'username'.time();
        $password = 'password'.time();
        $email = 'email'.time();
        $date = new \DateTime();

        $form = $crawler->selectButton('titredubouton')->form([
            'appbundle_user[username]' => $username,
            'appbundle_user[password]' => $password,
            'appbundle_user[email]' => $email,
            'appbundle_user[birthday]' => $date
        ]);
       // $form['avatar']->upload('web/upload/defaut.jpg');

        $crawler = $client->submit($form);
    }

}