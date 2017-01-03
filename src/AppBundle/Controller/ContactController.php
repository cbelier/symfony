<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
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
    ]
];
        $nom = "BELIER";
        $prenom = "Charlie";

        //replace this example code with whatever you need
        return $this->render('contact.html.twig', [
            'nom' => $nom,
            'prenom' => $prenom,
            'products' => $products
        ]);
    }
}