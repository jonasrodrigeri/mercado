<?php

namespace App\Controllers;

use Twig\Environment;
use App\Models\TipoProduto;
use Illuminate\Database\Capsule\Manager;

class TipoProdutoController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function lista()
    {
        $mensagem = $_SESSION['mensagem'];
        $_SESSION['mensagem'] = [];

        try {
            $tiposProduto = Manager::table('tipo_produto')
                ->select('tipo_produto.*')
                ->orderBy('nome', 'asc')
                ->get();
        } catch (\Exception $e) {
            $tiposProduto = [];
        }

        return $this->twig->render('tipo-produto/index.html', ['tiposProduto' => $tiposProduto, 'mensagem' => $mensagem]);
    }

    public function inserir()
    {
        return $this->twig->render('tipo-produto/inserir.html', []);
    }

    public function editar($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /tipo-produto");
        }

        $id = $params[1];

        try {
            $tipoProduto = TipoProduto::where('id', $id)->first();
        } catch (\Exception $e) {
            $tipoProduto = [];
        }

        $mensagem = $_SESSION['mensagem'];
        $_SESSION['mensagem'] = [];

        return $this->twig->render('tipo-produto/editar.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $tipoProduto, 'id' => $id, 'mensagem' => $mensagem]);
    }

    public function insere()
    {
        $dados = $_POST;

        $dados['percentual_imposto'] = str_replace(',', '.', str_replace('.', '', $dados['percentual_imposto']));

        $tipoProduto = new TipoProduto;
        $tipoProduto->nome = $dados['nome'];
        $tipoProduto->percentual_imposto = $dados['percentual_imposto'];

        try {
            $tipoProduto->save();
        } catch (\Exception $e) {
            $mensagem = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao inserir tipo do produto'];
            return $this->twig->render('tipo-produto/inserir.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $_POST, 'mensagem' => $mensagem]);
        }

        $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Tipo do produto inderido com sucesso'];

        return header("location: /tipo-produto");
    }

    public function edita($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /tipo-produto");
        }

        $id = $params[1];
        $dados = $_POST;

        $dados['percentual_imposto'] = str_replace(',', '.', str_replace('.', '', $dados['percentual_imposto']));

        $tipoProduto = TipoProduto::where('id', $id)->first();
        $tipoProduto->nome = $dados['nome'];
        $tipoProduto->percentual_imposto = $dados['percentual_imposto'];

        try {
            $tipoProduto->save();
        } catch (\Exception $e) {
            $mensagem = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao editar tipo do produto'];
            return $this->twig->render('tipo-produto/editar.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $tipoProduto, 'mensagem' => $mensagem, 'id' => $id]);
        }

        $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Tipo do produto editado com sucesso'];

        return header("location: /tipo-produto");
    }

    public function exclui($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /tipo-produto");
        }

        $id = $params[1];

        try {
            $ok = TipoProduto::find($id)->delete();
        } catch (\Exception $e) {
            $_SESSION['mensagem'] = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao excluir tipo do produto'];
        }

        if (!$ok) {
            $_SESSION['mensagem'] = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao excluir tipo do produto, ele já está vinculado a um produto'];
        } else {
            $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Tipo do produto excluído com sucesso'];
        }

        return header("location: /tipo-produto");
    }
}
