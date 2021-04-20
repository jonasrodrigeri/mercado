<?php

namespace App\Controllers;

use Twig\Environment;
use App\Models\Produto;
use App\Models\TipoProduto;
use Illuminate\Database\Capsule\Manager;

class ProdutoController
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
            $produtos = Manager::table('produto')
                ->select('produto.*', 'tipo_produto.nome as tpr_nome')
                ->join('tipo_produto', 'tipo_produto.id', '=', 'produto.tpr_id')
                ->orderBy('nome', 'asc')
                ->get();
        } catch (\Exception $e) {
            $produtos = [];
        }

        return $this->twig->render('produto/index.html', ['produtos' => $produtos, 'mensagem' => $mensagem]);
    }

    public function inserir()
    {
        return $this->twig->render('produto/inserir.html', ['tiposProduto' => TipoProduto::all()]);
    }

    public function editar($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /produto");
        }

        $id = $params[1];

        try {
            $produto = Produto::where('id', $id)->first();
        } catch (\Exception $e) {
            $produto = [];
        }

        $mensagem = $_SESSION['mensagem'];
        $_SESSION['mensagem'] = [];

        return $this->twig->render('produto/editar.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $produto, 'id' => $id, 'mensagem' => $mensagem]);
    }

    public function insere()
    {
        $dados = $_POST;

        $dados['valor'] = str_replace(',', '.', str_replace('.', '', $dados['valor']));

        $produto = new Produto;
        $produto->nome = $dados['nome'];
        $produto->valor = $dados['valor'];
        $produto->tpr_id = $dados['tipo_produto'];

        try {
            $produto->save();
        } catch (\Exception $e) {
            $mensagem = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao inserir produto'];
            return $this->twig->render('produto/inserir.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $_POST, 'mensagem' => $mensagem]);
        }

        $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Produto inderido com sucesso'];

        return header("location: /produto");
    }

    public function edita($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /produto");
        }

        $id = $params[1];
        $dados = $_POST;

        $dados['valor'] = str_replace(',', '.', str_replace('.', '', $dados['valor']));

        $produto = Produto::where('id', $id)->first();
        $produto->nome = $dados['nome'];
        $produto->valor = $dados['valor'];
        $produto->tpr_id = $dados['tipo_produto'];

        try {
            $produto->save();
        } catch (\Exception $e) {
            $mensagem = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao editar produto'];
            return $this->twig->render('produto/editar.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $produto, 'mensagem' => $mensagem, 'id' => $id]);
        }

        $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Produto editado com sucesso'];

        return header("location: /produto");
    }

    public function exclui($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /produto");
        }

        $id = $params[1];

        try {
            $ok = Produto::find($id)->delete();
        } catch (\Exception $e) {
            $_SESSION['mensagem'] = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao excluir produto'];
        }

        if (!$ok) {
            $_SESSION['mensagem'] = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao excluir produto, ele já está vinculado a uma venda'];
        } else {
            $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Produto excluído com sucesso'];
        }

        return header("location: /produto");
    }
}
