<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 27/01/17
 * Time: 15:11
 */

namespace adminBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class SearchController extends Controller
{
    /**
     * @Route("/search", name="search")
     */
    public function viewAction(Request $request){


        return $this->render('Public/search/search.html.twig',
            [
                'firstname' => "Charlie",
                'lastname' => "BELIER"
            ]);
    }

    /**
     * @Route("/search/ajax", name="search-ajax")
     */
    public function searchAction(Request $request){

        $data = $request->get("data");

        $doctrine = $this->getDoctrine();
        $res = $doctrine->getRepository('adminBundle:Product')->searchbyName($data);

        return new JsonResponse($res);
    }
}