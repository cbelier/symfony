<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("public/products", name="public_product")
     */
    public function ViewAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("adminBundle:Product")->findAll();

        $categories = $em->getRepository("adminBundle:Categorie")->findAll();
        asort($categories);


        return $this->render('Public/Products/index.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
            ]);

    }

    /**
     * @Route("public/products/{id}", name="public_show_product", requirements={"id" = "\d+"})
     */
    public function showProductAction($id){


        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")->find($id);

        $categories = $em->getRepository("adminBundle:Categorie")->findAll();
        asort($categories);

        if (empty($product)){
            throw $this->createNotFoundException("Le produit n'hexiste pas !");
        }


        return $this->render('Public/Products/IndivProduct.html.twig',
            [
                'product' => $product,
                'categories' => $categories,

            ]);
    }

}