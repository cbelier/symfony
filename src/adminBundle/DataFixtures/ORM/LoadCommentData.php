<?php

namespace adminBundle\DataFixtures\ORM;

use adminBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 1; $i++) {
            $comment = new Comment();

            $comment->setTitle('Titre du commentaire');
            $comment->setComment('Ceci est un commaitre fictif d un produit, vous pouvez le supprimer dans le back office du site');
            $comment->setAuthor('Admin');
            $comment->setNote(rand(0,5));
            $comment->setDateCreate(new \DateTime());

            $manager->persist($comment);
            $manager->flush();
            // création d'une variable afin de pouvoir relier un produit à une id comment existante
            $this->addReference('nouveau-commentaire'.$i, $comment);
        }
    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 4;
    }

}