<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 20/01/17
 * Time: 09:37
 */

namespace adminBundle\Subscriber;


use Doctrine\Common\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryFormSubscriber implements EventSubscriberInterface
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
            $form->remove('position');
            $form->add('description');
        }
        else{
            $form->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description est vide'
                    ])
                ]
            ]);
        }
    }
}