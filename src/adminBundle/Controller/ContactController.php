<?php

namespace adminBundle\Controller;

use AppBundle\Events\ConsultContactEvent;
use AppBundle\Events\ConsultEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/aide_twig", name="aide_twig")
     */
    public function contactAction(Request $request)
    {
        $eventDispatcher= $this->get('event_dispatcher');

        $event = new ConsultContactEvent();//On recupère l'evenement
        $event->setIp($request->getClientIp());//On récupere l'Ip

        $eventDispatcher->dispatch(ConsultEvents::CONTACT, $event);//On déclanche l'evement et on visit Contact

        $fileCSV = file('../var/logs/contactFormLogs.csv');


//        $products = [
//        [
//        "id" => 1,
//        "title" => "Mon premier produit",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 10
//        ],
//        [
//        "id" => 2,
//        "title" => "Mon deuxième produit",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 20
//        ],
//        [
//        "id" => 3,
//        "title" => "Mon troisième produit",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 30
//        ],
//        [
//        "id" => 4,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ],
//        [
//        "id" => 5,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ],
//        [
//        "id" => 6,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ],
//        [
//        "id" => 7,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ],
//        [
//        "id" => 8,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ],
//        [
//        "id" => 9,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ],
//        [
//        "id" => 10,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ],
//        [
//        "id" => 11,
//        "title" => "",
//        "description" => "lorem ipsum",
//        "date_created" => new \DateTime('now'),
//        "prix" => 410
//        ]
//        ];
//
        return $this->render('contact.html.twig',
            [
                'file' => $fileCSV,
                'firstname' => 'Charlie',
                'lastname' => 'BELIER'
            ]);
    }
}
