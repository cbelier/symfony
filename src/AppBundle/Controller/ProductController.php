<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use adminBundle\Entity\Comment;
use AppBundle\Form\PublicCommentForm;

class ProductController extends Controller
{
    /**
     * @Route("public/products", name="public_product")
     */
    public function ViewAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        $nbProductPerPage = 9;
        $page = $request->query->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }

        $offset = ($page - 1) * $nbProductPerPage;

        $nbPages = ceil($em->getRepository('adminBundle:Product')->nbProduct()/$nbProductPerPage);

        $products = $em->getRepository('adminBundle:Product')->myFindProduction($nbProductPerPage, $offset);


        return $this->render('Public/Products/index.html.twig',
            [
                'products' => $products,
                'nbpage' => $nbPages,
            ]);

    }

    /**
     * @Route("public/products/{id}", name="public_show_product", requirements={"id" = "\d+"})
     */
    public function showProductAction($id, Request $request){


        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("adminBundle:Product")->find($id);

        $objComment = new Comment();

        $formComment = $this->createForm(PublicCommentForm::class, $objComment);
        $formComment->handleRequest($request);

        if ($formComment->isSubmitted() && $formComment->isValid()) {

            $em = $this->getDoctrine()->getManager();

//            $product->addComment($objComment);

            $em -> persist($objComment);//Doctrine est au courant des changements
            $em -> flush();//On force
            // sauvegarde du produit

            $this->addFlash('success', 'Votre commentaire a bien été créer');

            return $this->redirectToRoute('public_show_product', ['id' => $id]);
        }


        $nbProductPerPageForComment = 5;
        $pageComment = $request->query->get('page', 1);
        if ($pageComment <= 0) {
            $pageComment = 1;
        }

        $offset = ($pageComment - 1) * $nbProductPerPageForComment;

        $nbPages = ceil($em->getRepository('adminBundle:Comment')->nbComment()/$nbProductPerPageForComment);

        $comments = $em->getRepository('adminBundle:Comment')->myFindProduction($nbProductPerPageForComment, $offset, $id);

        if (empty($product)){
            throw $this->createNotFoundException("Le produit n'hexiste pas !");
        }

        return $this->render('Public/Products/IndivProduct.html.twig',
            [
                'product' => $product,
                'comments' => $comments,
                'nbpage' => $nbPages,
                'formComment' => $formComment->createView(),
            ]);
    }

}