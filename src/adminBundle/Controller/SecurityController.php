<?php

namespace adminBundle\Controller;

use adminBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use adminBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints as Assert;
use adminBundle\Services\Utils\StringService;


class SecurityController extends Controller
{
    /**
     * @Route("login", name="security.login")
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');


        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("logout", name="security.logout")
     */
    public function logoutAction(Request $request)
    {
        //Cette fonction vide permet de déconnecter l'utilisateur
    }

    /**
     * @Route("signIn", name="security.signIn")
     */
    public function signInAction(Request $request)
    {
        $user = new User();
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        $rcRole = $this->getDoctrine()->getRepository('adminBundle:Role');

        if ($formUser->isSubmitted() && $formUser->isValid()) {

            $token = bin2hex(openssl_random_pseudo_bytes(16));

            $data = $formUser->getData();

            $encoderPassword = $this->get('security.password_encoder');
            $password = $encoderPassword->encodePassword($data, $data->getPassword());

            $data->setToken($token);
            $data->setPassword($password);

            $role = $rcRole->findOneBy([
                'name' => 'ROLE_USER'
            ]);
            $data->addRole($role);


            $em = $this->getDoctrine()->getManager();

            $em -> persist($data);//Doctrine est au courant des changements
            $em -> flush();//On force
            // sauvegarde du produit

            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Confirmer votre email')
                ->setFrom($data->getEmail())
                ->setTo('925901abb7-fccc9b@inbox.mailtrap.io')
                ->setBody(
                    $this->renderView(
                        'emails/formulaire-contact.html.twig',
                        [
                            'data' => $data->getEmail(),
                            'token' =>$token,
                        ])
                )
                ->setContentType('text/html');




            $this->get('mailer')->send($message);

            $this->addFlash('success', 'Votre inscription est validée');

            return $this->redirectToRoute('accueil');
        }

        return $this->render('Security/signIn.html.twig', [
            'formUser' => $formUser->createView()
        ]);
    }

    /**
     *
     * @Route("email/{token}", name="security.verify")
     */
    public function verifyAction($tokenEmail, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tokenBdd = $em->getRepository("adminBundle:User")->find($tokenEmail);
        //Cette fonction permet de vérifier le token
        if ($tokenEmail == $tokenBdd)
        {
            $em->setIsActive(1);
        }
        else{

        }
    }
}