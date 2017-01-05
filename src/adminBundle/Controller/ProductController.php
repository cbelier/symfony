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
            "date_created" => new \DateTime('-9 Days'),
            "prix" => 410
        ],
        [
            "id" => 9,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-110 Days'),
            "prix" => 410
        ],
        [
            "id" => 10,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-10 Days'),
            "prix" => 410
        ],
        [
            "id" => 11,
            "title" => "",
            "description" => "lorem ipsum",
            "date_created" => new \DateTime('-1 Days'),
            "prix" => 410
        ]
    ];
    }

    /**
     * @Route("/admin/products", name="products")
     */
    public function productAction()
    {
        $somme= 0;
        $moyenne = 0;
        $i = 0;
        $tab = [];
        $mini = $this->products[0]["prix"];

        foreach ($this->products as $product)
        {
            $i++;
            $somme += $product["prix"];

            if ($mini>$product["prix"]) {
                $mini = $product["prix"];
            }
            $tab[$i]=serialize($product["date_created"]);
        }

        $Nb = sizeof($this->products);
        $moyenne = $somme/$Nb;


        return $this->render('Products/products.html.twig',
                             [
                               'products' => $this->products,
                                 'moyenne' => $moyenne,
                                 'prix_mini' => $mini,
                                 'firstname' => "Charlie",
                                 'dates' => $tab,
                                'lastname' => "BELIER"
                             ]);
    }

    /**
     * @Route("/admin/products/{id}", name="show_product", requirements={"id" = "\d+"})
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
