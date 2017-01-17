<?php

namespace adminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Categorie;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCategorieData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 1; $i++) {
            $categorie = new Categorie();
            $categorie->setTitle('Nouveau Produit')
                ->setDescription('Description du produit')
                ->setPosition(rand(0, 50))
                ->setActive(1)
                ->setImage('defaut.jpg');


            $manager->persist($categorie);
            $manager->flush();


        }
    }
        public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 1;
    }


}