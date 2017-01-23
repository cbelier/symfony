<?php

namespace AppBundle\Controller;

use adminBundle\Entity\User;
use adminBundle\Form\UserType;
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
    public function clientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        // Création du formulaire ProductType permettant de créer un produit
        // Je lie le formulaire à mon objet $product
        $formUser = $this->createForm(UserType::class, $user);

        // Je lie la requête ($_POST) à mon formulaire donc à mon objet $product
        $formUser->handleRequest($request);

        // Je valide mon formulaire
        if ($formUser->isSubmitted() && $formUser->isValid()) {

            // La ligne ci-dessous n'est pas obligatoire car doctrine est au courant de l'existance de $product
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre compte a été mis à jour');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('Public/SessionClient.html.twig',
            [
                'formUser' => $formUser->createView(),
                'userConnected' => $user
            ]);
    }
}
