<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 23/01/17
 * Time: 09:37
 */

namespace adminBundle\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SignUpFormSubscriber implements EventSubscriberInterface
{
    //une interface est une sorte de modèle qui doit implémenter une méthode

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.

        return [
            FormEvents::POST_SET_DATA => 'postSetData' //On récupère les évenements après le POST
        ];
    }

    //Ne pas oublier de l'inclure dans le services.yml et rajouter le souscripteur dans la classe ici formulaire
    //On utilise le souscripteur pour insérer des contraintes

    public function postSetData(FormEvent $event){
        $entity = $event->getData();
        $form = $event->getForm();

        if ($entity->getId())
        {
            $form->remove('birthday');
            $form->add('birthday', DateType::class, array(
                'html5' => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'js-datepicker form-control',
                    'placeholder' =>  'date de naissance '
                ]));
        }
    }
}