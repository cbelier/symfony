<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 26/01/17
 * Time: 09:47
 */

namespace AppBundle\Events;


use Symfony\Component\EventDispatcher\Event;

class ConsultContactEvent extends Event
{
    private $ip;

    /**
     * ConsultContactEvent constructor.
     * clique droit, generate
     */
    public function __construct()
    {

    }


    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }


}