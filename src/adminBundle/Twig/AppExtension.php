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

    public function ma_fonction($theme = null) {
        $res = $this->doctrine->getRepository('adminBundle:Categorie')->findAll();

        $template = 'Public/Categories/renderCategories.html.twig';

        if ($theme == 'back') {
            $template = 'Categories/renderCategories.html.twig';
        }

        return $this->twig->render($template, [
            'categories' => $res,
        ]);

    }

}