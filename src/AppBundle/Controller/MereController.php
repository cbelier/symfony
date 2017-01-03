<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MereController extends Controller
{
    /**
     * @Route("/mere", name="mere")
     */
    public function indexAction(Request $request)
    {
        //replace this example code with whatever you need
        return $this->render('mere.html.twig');
    }
}