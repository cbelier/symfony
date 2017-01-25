<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 25/01/17
 * Time: 14:22
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TunelPaymentController
{
    /**
     * @Route("tunelPayment", name="tunelPayment")
     */
    public function viewAction(Request $request)
    {

        return $this->render('Public/Accueil.html.twig',
            [
                'products' => 'c'
            ]);
    }
}