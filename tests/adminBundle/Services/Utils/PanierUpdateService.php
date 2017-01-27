<?php
/**
 * Created by PhpStorm.
 * User: wamobi12
 * Date: 25/01/17
 * Time: 16:16
 */

namespace adminBundle\Services\Utils;


class PanierUpdateService
{
    public function modeleUpdate($panier, $session){
        $nbArticle = 0;
        foreach ($panier as $key => $value){
            $nbArticle += $value;
        }

        $session->set('nbArticle', $nbArticle);

        return $nbArticle;
    }
}