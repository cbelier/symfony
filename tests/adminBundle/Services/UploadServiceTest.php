<?php

namespace tests\adminBundle\Services;

use adminBundle\Services\Utils\StringService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UploadServiceTest extends WebTestCase
{
//    private $stringUtilService;
//    private $uploadDir;


//    public function __construct(StringService $stringUtilService, $uploadDir)
//    {
//        $this->stringUtilService = $stringUtilService;
//
//        $this->uploadDir = $uploadDir;
//    }

    public function testUpLoadService($image){

        //$servicesUtils = $this->get('admin.services.utils.string');
        $imageName = $this->stringUtilService->generateUniqId();

        $file = $imageName.'.'.$image->guessExtension();
        $image->move($this->uploadDir, $file);


        return $file;

    }

}