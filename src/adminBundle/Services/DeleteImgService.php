<?php

namespace adminBundle\Services;


class DeleteImgService
{
    private $uploadDir;

    public function __construct($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function removeImg ($file){
        unlink($this->uploadDir.$file);
    }
}