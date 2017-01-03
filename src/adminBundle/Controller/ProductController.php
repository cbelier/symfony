<?php

namespace adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProductController extends Controller
{
    /**
     * @Route("/admin/products", name="products")
     */
    public function productAction()
    {
      $products = [
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
    ];
        return $this->render('adminBundle:Products:products.html.twig', 
                             [
                               'products' => $products,
                               'firstname' => "Charlie",
                                'lastname' => "BELIER"
                             ]);
    }
}
