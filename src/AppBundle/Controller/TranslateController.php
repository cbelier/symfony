<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TranslateController extends Controller
{
    /**
     * @Route("/translate", name="translate")
     */
    public function indexAction(Request $request)
    {
        $locale = $request->getLocale();

        $doctrine = $this->getDoctrine();
        $result = $doctrine->getRepository('adminBundle:Product')->findProductByLocale(45, $locale);

        //replace this example code with whatever you need
        return $this->render('Public/Translate.html.twig');
    }
}
