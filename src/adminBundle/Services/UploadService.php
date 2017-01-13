<?php

namespace adminBundle\Services;

use adminBundle\Services\Utils\StringService;


class UploadService
{
    private $stringUtilService;
    private $uploadDir;


    public function __construct(StringService $stringUtilService, $uploadDir)
    {
        $this->stringUtilService = $stringUtilService;

        $this->uploadDir = $uploadDir;
    }

    public function upLoadService($image){

        //$servicesUtils = $this->get('admin.services.utils.string');
        $imageName = $this->stringUtilService->generateUniqId();

        $file = $imageName.'.'.$image->guessExtension();
        $image->move($this->uploadDir, $file);


        return $file;

    }

}