<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 23/01/17
 * Time: 12:05
 */

namespace adminBundle\Subscriber;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelEventsSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $session;

    public function __construct(\Twig_Environment $twig, Session $session)
    {
        $this->twig = $twig;
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.
        return [
//            KernelEvents::REQUEST => 'kernelRequest'
//            KernelEvents::REQUEST => 'blockCountry',
            KernelEvents::RESPONSE => 'addCookiesBlock'

        ];
    }

    public function addCookiesBlock(FilterResponseEvent $event){
        $content = $event->getResponse()->getContent();

        if(!$this->session->has('disclaimer')) {

            $content = str_replace('<div class="cookies"></div>', '
                    <div class="cookies">
                    <div class="maia-notification maia-stage display" id="cookie-statement">
                      <div class="text">
                        <span>Nous diffusons des cookies afin d\'analyser le trafic sur ce site. Les informations
                        concernant l\'utilisation que vous faites de notre site nous sont transmises dans cette
                        optique.</span><br /><a href="http://www.google.com/intl/fr/policies/technologies/cookies/" class="btn btn-default" ">En savoir plus</a> <button class="btn btn-warning" id="closed">OK</button>
                      </div>
                    </div>
                     </div>
                ', $content);
        }

        $response = new Response($content);
        $event->setResponse($response);
    }

    public function blockCountry(GetResponseEvent $event){
//        $ip = $event->getRequest()->getClientIp();
        $ip = '89.227.222.139';
        $ipService = file_get_contents("http://www.webservicex.net/geoipservice.asmx/GetGeoIP?IPAddress=$ip");
        $xml = simplexml_load_string($ipService);

        $content = $event->getResponse();

        if ($xml->CountryName != 'France'){
            $view = $this->twig->render('Public/Maintenance.html.twig');
            $response = new Response($view, 503);
            $event->setResponse($response);
        }

    }

    public function KernelRequest(GetResponseEvent $event){
//        die(dump('kernel request'));
        $request = $event->getRequest();
        $content = $event->getResponse();

        $view = $this->twig->render('Public/Maintenance.html.twig');
        $response = new Response($view, 503);
        $event->setResponse($response);

    }
}