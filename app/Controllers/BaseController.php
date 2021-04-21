<?php

namespace App\Controllers;

class BaseController
{
    public function insereMessage(array $mensagem)
    {
        $_SESSION['mensagem'] = $mensagem;
    }

    public function retornaMessage()
    {
        $mensagem = $_SESSION['mensagem'];
        $_SESSION['mensagem'] = [];

        return $mensagem;
    }

    public function retornaMenssagensDeErro(array $erros, $retornarMensagem = true)
    {
        $mensagensDeErro = [];

        foreach ($erros as $erro) {
            foreach ($erro as $mensagem) {
                array_push($mensagensDeErro, $mensagem);
            }
        }

        $this->insereMessage($mensagensDeErro);

        if ($retornarMensagem) {
            return $this->retornaMessage();
        }
    }
}
