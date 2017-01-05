<?php

namespace adminBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FeedbackController extends Controller
{
    /**
     * @Route("/admin/feedback", name="feedback")
     */
    public function feedbackAction(Request $request)
    {
        //Ici on fait un formulaire et on ajoute les champs avec la methode add
        $formContact = $this->createFormBuilder()
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('email', EmailType::class)
            ->add('content', TextareaType::class)
            ->add('page', TextType::class)
            ->add('date', DateType::class, array(
                'widget' => 'single_text',

                // do not render as type="date", to avoid HTML5 date pickers
                'html5' => false,
            ))
            /*
            ->add('date', DateType::class,
                [
                    'format' => 'dd MMM yyyy',
                    'years' => range( date('Y')-10, date('Y')+10 )
                ])
            */
            ->add('bug', ChoiceType::class, array(
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                        'Page inaccessible' => 'inaccessible',
                        'autre' => 'autre',
                        'Problème orthograph' => 'orthograph',
                        'Affichage incorrect' => 'incorrect'
                )))
            ->add('save', ButtonType::class)
            ->getForm();

        //Cela permet de remplir le formulaire avec les info stockées dans $request (méthode POST)
        $formContact->handleRequest($request);


        // Je vérifie que le formulaire est bien soumis et qu'il est valide
        if ($formContact->isSubmitted() && $formContact->isValid()) {

            // La technique à utiliser est d'utiliser une variable ex: $data et de manipuler cette variable
            $data = $formContact->getData();

            // Envoie du mail
            $message = \Swift_Message::newInstance()
                ->setSubject('Formulaire de contact')
                ->setFrom($data['email'])
                ->setTo([
                    'contact@gmail.com',
                    $this->getParameter('mail_admin')])
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
            $this->addFlash('success', 'Merci '. $data["firstname"].' ! Ton email a bien été envoyé');

            // Redirection : Préciser le nom de la route dans la méthode 'redirectToRoute'
            return $this->redirectToRoute('feedback');
        }


        return $this->render('Default/feedback.html.twig', [
            "formContact" => $formContact->createView()
        ]);
    }
}
