<?php

namespace tests\adminBundle\Services;


use adminBundle\Services\DeleteImgService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeleteImgServiceTest extends WebTestCase
{
    private $uploadDir;

//    public function __construct($uploadDir)
//    {
//        $this->uploadDir = $uploadDir;
//    }

    public function testRemoveImg(){
        $container = $this->createClient()->getContainer();
        $uploadDir = $container->getParameter('upload_dir');

        $unlinkService = new  DeleteImgService($uploadDir);

        file_put_contents('tests/tempFile.txt', 'Hello handsome !\n What\'s up ?');

        $this->assertTrue(file_exists('tests/tempFile.txt'));



    }
}