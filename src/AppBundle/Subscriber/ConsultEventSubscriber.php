<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 26/01/17
 * Time: 09:54
 */

namespace AppBundle\Subscriber;


use AppBundle\Events\ConsultContactEvent;
use AppBundle\Events\ConsultEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConsultEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return[
          ConsultEvents::CONTACT => 'consultContact'
        ];
    }

    //Lié au contact de l'Event
    public function consultContact(ConsultContactEvent $event){
//        dump('consult.contact.event');
        $ip = $event->getIp();
        $date = new \DateTime();

        file_put_contents('../var/logs/contactFormLogs.csv', $ip . ';' . $date->format('d/m/Y H:i:s')."\n", FILE_APPEND);

    }

}