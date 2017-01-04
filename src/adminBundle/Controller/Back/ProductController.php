<?php

namespace adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    private $products;

    public function __construct()
    {
        $this->products = [
        [
            "id" => 1,
            "title" => "Mon premier produit",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 10
        ],
        [
            "id" => 2,
            "title" => "Mon deuxième produit",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 20
        ],
        [
            "id" => 3,
            "title" => "Mon troisième produit",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 30
        ],
        [
            "id" => 4,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 5,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 6,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 7,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 8,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 9,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 10,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        [
            "id" => 11,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('now'),
            "prix" => 410
        ],
        1 => [
            "id" => 12,
            "title" => "Homme",
            "description" => "lorem ipsum \n suite du contenu",
            "date_created" => new \DateTime('now'),
            "active" => true
        ],
        2 => [
            "id" => 2,
            "title" => "Femme",
            "description" => "<strong>lorem</strong> ipsum",
            "date_created" => new \DateTime('-10 Days'),
            "active" => true
        ],
        3 => [
            "id" => 3,
            "title" => "Enfant",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-1 Days'),
            "active" => false
        ],
    ];
    }

    /**
     * @Route("/products", name="products")
     */
    public function productAction()
    {

        return $this->render('Products/products.html.twig',
                             [
                               'products' => $this->products,
                               'firstname' => "Charlie",
                                'lastname' => "BELIER"
                             ]);
    }

    /**
     * @Route("/products/{id}", name="show_product", requirements={"id" = "\d+"})
     */
    public function showProductAction($id){


        $produit = [];
        foreach ($this->products as $product)
        {
            if ($product["id"]==$id)
            {
                $produit = $product;
            }
        }

        if (empty($produit)){
            throw $this->createNotFoundException("Le produit n'hexiste pas !");
        }



        return $this->render('Products/indivProducts.html.twig',
            [
                'firstname' => "Charlie",
                'product' => $produit,
                'lastname' => "BELIER"
            ]);
    }
}
