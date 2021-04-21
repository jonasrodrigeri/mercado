<?php

namespace App\Controllers;

class BaseController
{
    public function insereMessage(array $mensagem)
    {
        $_SESSION['mensagem'] =  $mensagem;
    }

    public function retornaMessage()
    {
        $mensagem = $_SESSION['mensagem'];
        $_SESSION['mensagem'] = [];

        return $mensagem;
    }
}
