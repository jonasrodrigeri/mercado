<?php

namespace App\Controllers;

use Twig\Environment;

class HomeController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        return $this->twig->render('home/dashboard.html');
    }

    public function error404()
    {
        return $this->twig->render('erro/404.html');
    }
}
