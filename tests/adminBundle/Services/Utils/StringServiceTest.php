<?php

namespace tests\adminBundle\Services\Utils;


use adminBundle\Services\Utils\StringService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StringServiceTest extends WebTestCase
{
    public function testGenerateUniqId(){
        $stringService = new StringService();

        $v1 = $stringService->generateUniqId();

        $this->assertEquals(32, strlen($v1));
        return $v1;

    }
}