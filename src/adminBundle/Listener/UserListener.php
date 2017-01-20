<?php

namespace adminBundle\Listener;


use adminBundle\Entity\User;
use adminBundle\Services\DeleteImgService;
use adminBundle\Services\UploadService;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class UserListener
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


    /**
     * @param User $entity
     * @param LifecycleEventArgs $args
     */
    public function prePersist(User $entity, LifecycleEventArgs $args){

        $entity->setDateCreate(new \DateTime());


        $image = $entity->getAvatar();

        if (is_null($image)){
            $fileName = $this->defautImage;
        }
        else{
            $fileName = $this->uploadService->upLoadService($image);
        }

        $entity->setAvatar($fileName);
    }

    public function preUpdate(User $entity, LifecycleEventArgs $args){

        $image = $entity->getAvatar();

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

        $entity->setAvatar($fileName);
    }

    public function postLoad(User $entity, LifecycleEventArgs $args){
        $this->imageLoad = $entity->getAvatar();
    }

    public function postRemove(User $entity, LifecycleEventArgs $args){
        if ($this->imageLoad !== $this->defautImage) {
            $this->deleteImgService->removeImg($this->imageLoad);
        }
    }

}