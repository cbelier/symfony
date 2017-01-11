<?php

namespace adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$tousLesProduits = $em->getRepository('adminBundle:Product')->myFind(24);
        //$quantiteInferieur20 = $em->getRepository('adminBundle:Product')->findByQuantity(20);
        //$produitNonDisponible = $em->getRepository('adminBundle:Product')->findByQuantityStrict(0);
        //$produitNonDisponible = $em->getRepository('adminBundle:Product')->nbCat();
        //$produitNonDisponible = $em->getRepository('adminBundle:Product')->nbCatActive(1);
        //$produitNonDisponible = $em->getRepository('adminBundle:Product')->nbCatActiveAndNot();
        //$nbProduct = $em->getRepository('adminBundle:Product')->nbProduct();
        //$totalQteProduits = $em->getRepository('adminBundle:Product')->totalQteProduits();
        //$trouverProduit = $em->getRepository('adminBundle:Product')->findProduct();
        //$trouverProduit = $em->getRepository('adminBundle:Product')->findReg();




        return $this->render('Default/index.html.twig',
                             [
                                 'firstname' => 'Charlie',
                               'lastname' => 'BELIER'
                             ]);
    }
}
