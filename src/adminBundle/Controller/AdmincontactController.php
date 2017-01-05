<?php

namespace adminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdmincontactController extends Controller
{
    /**
     * @Route("admin/contact", name="contactadmin")
     */
    public function AdmincontactAction(Request $request)
    {
        //Ici on fait un formulaire et on ajoute les champs avec la methode add
        $formContact = $this->createFormBuilder()
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('content', TextareaType::class)
            ->add('save', ButtonType::class)
            ->getForm();

        //On lie l'objet $request avec le formulaire
        //Cela permet de remplir le formulaire avec les info stockées dans $request (méthode POST)
        $formContact->handleRequest($request);


        // Je vérifie que le formulaire est bien soumis et qu'il est valide
        if ($formContact->isSubmitted() && $formContact->isValid()) {
            // Dump de $_POST
            //dump($request->request->all());

            // Dump de $_GET
            //dump($request->query->all());

            // Récupérer les informations du formulaire
            //dump($formContact->getData());

            // Récupérer une valeur précisément du formulaire
            //dump($formContact->get('firstname')->getData());

            // La technique à utiliser est d'utiliser une variable ex: $data et de manipuler cette variable
            $data = $formContact->getData();

            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de contact')
                ->setFrom($data['email'])
                ->setTo('recipient@example.com')
                ->setBody(
                        $this->renderView(
                            'emails/formulaire-contact.html.twig',
                            ['data' => $data]),
                            'text/html'
                        )

                ->addPart(
                        $this->renderView(
                            'emails/formulaire-contact.txt.twig',
                            ['data' => $data]),
                            'text/plain'
                        );

            $this->get('mailer')->send($message);

            // Affichage d'un message de success
            $this->addFlash('success', 'Votre email n\'a pas été envoyé');

            // Redirection : Préciser le nom de la route dans la méthode 'redirectToRoute'
            return $this->redirectToRoute('contactadmin');
        }

        return $this->render('Default/AdminContact.html.twig', [
            "formContact" => $formContact->createView()
        ]);
    }
}
