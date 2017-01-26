<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 24/01/17
 * Time: 11:50
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use adminBundle\Entity\Product;
use adminBundle\Services\Utils\PanierUpdateService;




class AjouterProduitPanierController extends Controller
{

    /**
     * @Route("ajouterProduitPanier", name="ajouter_Produit_Panier")
     */
    public function ajouterAction(Request $request)
    {
        $id = $request->get('id');

        $session = $request->getSession();

        if (!$session->has('panier')) {
            $session->set('panier',array());
        }

        $panier = $session->get('panier');


//dump(array_key_exists($id, $panier)); exit();
        if (array_key_exists($id, $panier)) {
            if ($request->get('qte') != null)
            {
                $panier[$id] += $request->get('qte');
            }

            $this->get('session')->getFlashBag()->add('success','La quantité est modifié');
        }

        //dump($panier); exit;
        else
            {
            if ($request->get('qte') != null){
                $panier[$id] = $request->get('qte');
            }
            else
            {
                $panier[$id] = 1;
            }

          $this->get('session')->getFlashBag()->add('success','Article ajouté');
        }

        $session->set('panier',$panier);

        $nbArticle = 0;
        foreach ($panier as $key => $value){
            $nbArticle += $value;
        }

        $session->set('nbArticle', $nbArticle);
        //dump($nbArticle);

        return new JsonResponse(['nbArticle'=>$nbArticle]);

    }

    /**
     * @Route("updateQuantityProduitPanier", name="updateQuantityProduitPanier")
     */
    public function updateQteAction(Request $request)
    {
        $id = $request->get('id');

        $session = $request->getSession();

        $panier = $session->get('panier');


        if (array_key_exists($id, $panier)) {
            $panier[$id] = $request->get('qte');
        }

        else
        {
            if ($request->get('qte') != null){
                $panier[$id] = $request->get('qte');
            }
        }

        $session->set('panier',$panier);

        $updateservice = $this->get('admin.services.utils.panierUpdate');
        $nbArticle = $updateservice->modeleUpdate($panier, $session);

        return new JsonResponse(['nbArticle'=>$nbArticle]);
    }

    /**
     * @Route("public/accueil/panier", name="panier")
     */
    public function panierAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) {
            $session->set('panier', array());
        }

        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('adminBundle:Product')->findArray(array_keys($session->get('panier')));

        return $this->render('Public/Panier.html.twig', array('products' => $produits,
            'panier' => $session->get('panier')));
    }

    /**
     * @Route("public/accueil/panierUpdate", name="panierUpdate")
     */
    public function updateAction(Request $request)
    {
        $session = $request->getSession();
        if (!$session->has('panier')) {
            $session->set('panier', array());
        }

        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('adminBundle:Product')->findArray(array_keys($session->get('panier')));

        return $this->render('Public/Panier.html.twig', array('products' => $produits,
            'panier' => $session->get('panier')));
    }

    /**
     * @Route("public/accueil/panierDeletebyId", name="panierDeletebyId")
     */
    public function supprimerAction(Request $request)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');
        $prixQTE = $session->get('prixArticlesSelonQte');

        $id = $request->get('id');

        if (array_key_exists($id, $panier))
        {
            unset($panier[$id]);
            $session->set('panier',$panier);
        }

        $nbArticle = $this->panierUpdateUntilService->modeleUpdate($panier, $prixQTE, $session);


        return new JsonResponse(['nbArticle'=>$nbArticle]);
    }


}