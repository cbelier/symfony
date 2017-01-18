<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;



class ClientController extends Controller
{

    /**
     * @Route("public/client", name="public_client")
     */
    public function categorieAction(Request $request)
    {


        return $this->render('Public/SessionClient.html.twig',
            [
                'categories' => 'Categorie',
            ]);
    }



}
