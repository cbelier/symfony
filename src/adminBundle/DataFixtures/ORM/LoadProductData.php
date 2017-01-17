<?php
namespace adminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use adminBundle\Entity\Product;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $arrayBrand = [];
        for ($i = 0; $i < 1; $i++) {
            $arrayBrand[] = $this->getReference('nouvelle-marque-'.$i);

        }

        $arrayComment = [];
        for ($i = 0; $i < 1; $i++) {
            $arrayComment[] = $this->getReference('nouveau-commentaire'.$i);

        }

        for ($i=0; $i < 1; $i++) {
            $product = new Product();
            $product->setTitle('produit ' . $i)
                ->setDescription('Description du produit ' . $i)
                ->setPrice(rand(0, 50))
                ->setQuantity(rand(0,50));
//            $brand = $this->getReference('nouvelle-marque');
            //$brand = $this->getReference('marque'.$i);
            $brand = $arrayBrand[array_rand($arrayBrand, 1)];
            //die(dump($brand));
            $product->setBrand($brand);

            $comment = $arrayComment[array_rand($arrayComment, 1)];
            $product->setComment($comment);

            $product->setImage('defaut.jpg');
            $product->setDateCreate(new \DateTime());
            $product->setDateUpdate(new \DateTime());

            $manager->persist($product);
            $manager->flush();
        }

    }

    public function getOrder()
    {
        // Permet de choisir l'ordre d'execution des fixtures
        return 3;
    }

}