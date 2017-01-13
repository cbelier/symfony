<?php

namespace adminBundle\Twig;


use Doctrine\Bundle\DoctrineBundle\Registry;

class AppExtension extends \Twig_Extension //Va chercher la classe twig de symfony
{
    private $doctrine;
    private $twig;

    public function __construct(Registry $doctrine, \Twig_Environment $twig)
    {
        $this->doctrine = $doctrine;
        $this->twig = $twig;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('ma_fonction', [$this, 'ma_fonction'])
        ];
    }

    public function ma_fonction(){
        $res = $this->doctrine->getRepository('adminBundle:Categorie')->findAll();
        return $this->twig->render('Categories/renderCategories.html.twig', [
            'categories' => $res,
        ]);

    }

}