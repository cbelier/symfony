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
use Symfony\Component\Validator\Constraints as Assert;

class FeedbackController extends Controller
{
    /**
     * @Route("/admin/feedback", name="feedback")
     */
    public function feedbackAction(Request $request)
    {
        //Ici on fait un formulaire et on ajoute les champs avec la methode add
        $formContact = $this->createFormBuilder()
            ->add('firstname', TextType::class, [
        'constraints' =>
            [
                new Assert\NotBlank(['message' => 'Veuillez rentrer votre prenom']),
                new Assert\Length(array(
                    'min'        => 2,
                    'minMessage' => 'Ton prénom doit contenir au moins de 2 lettres'
                ))
            ]
    ])
            ->add('lastname', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre nom'])
                    ]
            ])
            ->add('email', EmailType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer un email']),
                        new Assert\Email([
                            'message' => 'Votre email {{ value }} est invalide',
                            'checkMX' => true,
                        ])
                    ]
            ])
            ->add('content', TextareaType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer votre message']),
                        new Assert\Length(array(
                            'min' => 10,
                            'max' => 150,
                            'minMessage' => 'Nombre de caractère maximum: 150',
                            'maxMessage' => 'Nombre de caractère minimum: 10'
                        )),
                        new Assert\Regex(array(
                            'pattern' => (
                            "/pute|petite(\s|&nbsp;)*pute|grosse(\s|&nbsp;)*pute|sale(\s|&nbsp;)*pute|espèce(\s|&nbsp;)*de(\s|&nbsp;)*pute|espece(\s|&nbsp;)*de(\s|&nbsp;)*pute|es(\s|&nbsp;)*une(\s|&nbsp;)*pute|es(\s|&nbsp;)*qu'une(\s|&nbsp;)*pute|putain|sal0pe |petite(\s|&nbsp;)*sal0pe|grosse(\s|&nbsp;)*sal0pe|sale(\s|&nbsp;)*sal0pe|espèce(\s|&nbsp;)*de(\s|&nbsp;)*sal0pe|espece(\s|&nbsp;)*de(\s|&nbsp;)*salope|es(\s|&nbsp;)*une(\s|&nbsp;)*salope|es(\s|&nbsp;)*qu'une(\s|&nbsp;)*salope|saloppe|(\s|&nbsp;)*de(\s|&nbsp;)*merde/i"
                            ),
                            'match' => false,
                            'message' => 'Veuillez surveiller votre langage'
                        ))
                    ]
            ])
            ->add('page', TextType::class, [
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez rentrer l url du problème']),
                        new Assert\Url(array(
                            'message' => 'L url "{{ value }}" n est pas valide.'))
                    ]
            ])
            ->add('date', DateType::class,
                array(
                    'years' => range( date('Y')-10, date('Y')+10 ),
                    'format' => 'dd-MMM-yyyy',
                    'widget' => 'single_text',
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
                'constraints' =>
                    [
                        new Assert\NotBlank(['message' => 'Veuillez choisir un bug'])
                    ],
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                        'Page inaccessible' => 'inaccessible',
                        'autre' => 'autre',
                        'Problème orthograph' => 'orthograph',
                        'Affichage incorrect' => 'incorrect'
                )))
            /*
             * $choicesStatut = ['technique', 'design', 'autre'];

            ->add('statut', ChoiceType::class,
	[
		'choices' => $choicesStatut,
		'constraints' => [
			new Assert\Choice([
				'choices' => $choicesStatut
			])
		]
	])
            */
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
