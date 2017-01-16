<?php

namespace AppBundle\Controller;

use adminBundle\Entity\Categorie;
use adminBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;



class CategoriesController extends Controller
{

    /**
     * @Route("public/categories", name="public_categories")
     */
    public function categorieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $nbProductPerPage = 4;
        $page = $request->query->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }

        $offset = ($page - 1) * $nbProductPerPage;

        $nbPages = ceil($em->getRepository('adminBundle:Categorie')->nbCat()/$nbProductPerPage);

        $categories = $em->getRepository('adminBundle:Categorie')->myFindProduction($nbProductPerPage, $offset);



        return $this->render('Public/Categories/Categories.html.twig',
            [
                'categories' => $categories,
                'nbpage' => $nbPages,

            ]);
    }

    /**
     * @Route("public/categories/{id}", name="public_show_categorie", requirements={"id" = "\d+"})
     *
     * @ParamConverter("categorie", class="adminBundle:Categorie")
     */
    public function showCategorieAction($id, Request $request){


        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("adminBundle:Categorie")->find($id);

        if (empty($category)){
            throw $this->createNotFoundException("La catégorie n'hexiste pas !");
        }


        $nbProductPerPage = 4;
        $page = $request->query->get('page', 1);
        if ($page <= 0) {
            $page = 1;
        }

        $offset = ($page - 1) * $nbProductPerPage;

        $products = $em->getRepository('adminBundle:Product')->myFindProductionSelonCategorie($category->getId(), $nbProductPerPage, $offset);

        return $this->render('Public/Categories/IndivCategorie.html.twig',
            [
                'category' => $category,
                'products' => $products,

            ]);
    }


    public function renderCategorieAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('adminBundle:Categorie')->findAll();

        return $this->render('Categories/renderCategories.html.twig', ['categories' => $categories]);
    }


}
