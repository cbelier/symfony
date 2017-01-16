<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicController extends Controller
{
    /**
     * @Route("public/accueil", name="accueil")
     */
    public function ViewAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("adminBundle:Product")->findAll();

        $produitLesPlusEnStock = $em->getRepository('adminBundle:Product')->findbystock();


        return $this->render('Public/Accueil.html.twig',
            [
                'produitLesPlusEnStock' => $produitLesPlusEnStock,
                'products' => $products
            ]);

    }
}