<?php

namespace App\Controllers;

use App\Models\User;
use Twig\Environment;
use App\Models\Produto;

class HomeController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function hello($params)
    {
        return "Olá {$params[1]}";
    }

    public function insereProduto()
    {

        echo '<pre>';
        $produto = new Produto();
        var_dump($produto);
        die("Aqui");
        $produto->name = 'Erik';
        $produto->email = base64_encode(random_bytes(10)) . '@example.com';
        $produto->password = password_hash('secret', PASSWORD_DEFAULT);
        $produto->save();

        return header('location: /users');
    }

    public function listUsers()
    {
        return $this->twig->render('user/index.html', ['users' => User::all()]);
    }
}
