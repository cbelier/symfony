<?php

namespace adminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;


class AdmincontactController extends Controller
{
    /**
     * @Route("admin/contact", name="contactadmin")
     */
    public function AdmincontactAction(Request $request)
    {
        $formContact = $this->createFormBuilder()
        //Ici on fait un formulaire et on ajoute les champs avec la methode add
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
