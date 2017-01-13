<?php

namespace adminBundle\Services\Utils;


class StringService
{
    public function generateUniqId(){
        $resultat = bin2hex(openssl_random_pseudo_bytes(16));
        return $resultat;

    }
}