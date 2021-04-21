<?php

namespace App\Controllers;

use Twig\Environment;
use App\Models\TipoProduto;
use Illuminate\Database\Capsule\Manager;

class TipoProdutoController extends BaseController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function lista()
    {
        try {
            $tiposProduto = Manager::table('tipo_produto')
                ->select('tipo_produto.*')
                ->orderBy('nome', 'asc')
                ->get();
        } catch (\Exception $e) {
            $tiposProduto = [];
        }

        return $this->twig->render('tipo-produto/index.html', ['tiposProduto' => $tiposProduto, 'mensagem' => $this->retornaMessage()]);
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

        return $this->twig->render('tipo-produto/editar.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $tipoProduto, 'id' => $id, 'mensagem' => $this->retornaMessage()]);
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

        $this->insereMessage(['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Tipo do produto inderido com sucesso']);

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

        $this->insereMessage(['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Tipo do produto editado com sucesso']);

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
            $this->insereMessage(['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao excluir tipo do produto']);
        }

        if (!$ok) {
            $this->insereMessage(['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao excluir tipo do produto, ele já está vinculado a um produto']);
        } else {
            $this->insereMessage(['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Tipo do produto excluído com sucesso']);
        }

        return header("location: /tipo-produto");
    }
}
