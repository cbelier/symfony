<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrereController extends Controller
{
    /**
     * @Route("/mere/frere", name="frere")
     */
    public function indexAction(Request $request)
    {
        //replace this example code with whatever you need
        return $this->render('frere.html.twig');
    }
}
