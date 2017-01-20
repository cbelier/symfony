<?php

namespace adminBundle\Listener;


use adminBundle\Entity\Categorie;
use adminBundle\Services\DeleteImgService;
use adminBundle\Services\UploadService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class CategorieListener
{
    private $uploadService;
    private $defautImage;
    private $imageLoad;
    private $deleteImgService;


    public function __construct(UploadService $uploadService, DeleteImgService $deleteImgService, $defautImage)
    {
        $this->uploadService = $uploadService;
        $this->defautImage = $defautImage;
        $this->deleteImgService = $deleteImgService;
    }


    public function prePersist(Categorie $entity, LifecycleEventArgs $args){
        //$entity->setDateUpdate(new \DateTime());
        //$entity->setDateCreate(new \DateTime());


        $image = $entity->getImage();


        if (is_null($image)){
            $fileName = $this->defautImage;
        }
        else{
            $fileName = $this->uploadService->upLoadService($image);
        }

        $entity->setImage($fileName);
    }

    public function preUpdate(Categorie $entity, LifecycleEventArgs $args){
        //$entity->setDateUpdate(new \DateTime());

        $image = $entity->getImage();

        if (is_null($image)){
            if (is_null($this->imageLoad)){
                $fileName = $this->defautImage;
            }
            else{
                $fileName = $this->imageLoad;
            }
        }
        else{
            $fileName = $this->uploadService->upLoadService($image);
        }

        $entity->setImage($fileName);
    }

    public function postLoad(Categorie $entity, LifecycleEventArgs $args){
        $this->imageLoad = $entity->getImage();
    }

    public function postRemove(Categorie $entity, LifecycleEventArgs $args){
        if ($this->imageLoad !== $this->defautImage) {
            $this->deleteImgService->removeImg($this->imageLoad);
        }
    }

}