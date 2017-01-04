<?php

namespace adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategorieController extends Controller
{
    private $products;

    public function __construct()
    {
        $this->products = [
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
        ]
    ];
    }

    /**
     * @Route("/admin/categories", name="categories")
     */
    public function productAction()
    {

        return $this->render('Categories/categories.html.twig',
                             [
                               'products' => $this->products,
                               'firstname' => "Charlie",
                                'lastname' => "BELIER"
                             ]);
    }

    /**
     * @Route("/admin/categories/{id}", name="show_cat", requirements={"id" = "\d+"})
     */
    public function showCatAction($id){


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



        return $this->render('Categories/indivCat.html.twig',
            [
                'firstname' => "Charlie",
                'product' => $produit,
                'lastname' => "BELIER"
            ]);
    }
}
