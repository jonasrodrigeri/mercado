<?php

namespace App\Controllers;

use Twig\Environment;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\VendaProduto;
use Illuminate\Database\Capsule\Manager;

class VendaController
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
            $vendas = Manager::table('venda')
                ->select('venda.*')
//                ->orderBy('nome', 'asc')
                ->get();
        } catch (\Exception $e) {
            $vendas = [];
        }

        return $this->twig->render('venda/index.html', ['vendas' => $vendas, 'mensagem' => $mensagem]);
    }

    public function inserir()
    {
        if (!isset($_SESSION['vendas'])) {
            $_SESSION['vendas'] = [];
        }

        $total = 0;
        $vendas = [];
        $impostos = 0;

        $_SESSION['total-vendas'] = $total;
        $_SESSION['detalhes-vendas'] = $vendas;
        $_SESSION['impostos-vendas'] = $impostos;

        if (!empty($_SESSION['vendas'])) {

            foreach ($_SESSION['vendas'] as $venda) {

                try {
                    $produto = Manager::table('produto')
                        ->select('produto.*', 'tipo_produto.percentual_imposto')
                        ->join('tipo_produto', 'tipo_produto.id', '=', 'produto.tpr_id')
                        ->where('produto.id', '=', $venda['produto'])
                        ->orderBy('nome', 'asc')
                        ->first();
                } catch (\Exception $e) {
                    $produto = [];
                }

                if (!empty($produto)) {

                    array_push($vendas, [
                        'id' => $produto->id,
                        'produto' => $produto->nome,
                        'valor' => $produto->valor,
                        'percentual_imposto' => $produto->percentual_imposto,
                        'quantidade' => $venda['quantidade'],
                        'total' => $produto->valor * $venda['quantidade'],
                        'total_imposto' => ($produto->valor * $venda['quantidade']) * ($produto->percentual_imposto / 100)
                    ]);

                    $total += $produto->valor * $venda['quantidade'];
                    $impostos += ($produto->valor * $venda['quantidade']) * ($produto->percentual_imposto / 100);

                }
            }

            $_SESSION['total-vendas'] = $total;
            $_SESSION['detalhes-vendas'] = $vendas;
            $_SESSION['impostos-vendas'] = $impostos;
        }

        $mensagem = $_SESSION['mensagem'];
        $_SESSION['mensagem'] = [];

        return $this->twig->render('venda/inserir.html', ['produtos' => Produto::all(), 'vendas' => $vendas, 'total' => $total, 'impostos' => $impostos, 'mensagem' => $mensagem]);
    }

    public function visualizar($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /venda");
        }

        $id = $params[1];

        try {
            $venda = Produto::where('id', $id)->first();
        } catch (\Exception $e) {
            $venda = [];
        }

        $mensagem = $_SESSION['mensagem'];
        $_SESSION['mensagem'] = [];

        return $this->twig->render('venda/visualizar.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $venda, 'id' => $id, 'mensagem' => $mensagem]);
    }

    public function insere()
    {
        $dados = $_POST;

        if (!isset($_SESSION['vendas'])) {
            $_SESSION['vendas'] = [];
        }

        array_push($_SESSION['vendas'], $dados);

        return header("location: /venda/inserir");
    }

    public function edita($params)
    {
        if (!isset($params[1]) || empty($params[1])) {
            return header("location: /venda");
        }

        $id = $params[1];
        $dados = $_POST;

        $dados['valor'] = str_replace(',', '.', str_replace('.', '', $dados['valor']));

        $venda = Produto::where('id', $id)->first();
        $venda->nome = $dados['nome'];
        $venda->valor = $dados['valor'];
        $venda->tpr_id = $dados['tipo_venda'];

        try {
            $venda->save();
        } catch (\Exception $e) {
            $mensagem = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao editar venda'];
            return $this->twig->render('venda/editar.html', ['tiposProduto' => TipoProduto::all(), 'dados' => $venda, 'mensagem' => $mensagem, 'id' => $id]);
        }

        $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Produto editado com sucesso'];

        return header("location: /venda");
    }

    public function limpar()
    {
        $_SESSION['vendas'] = [];

        return header("location: /venda/inserir");
    }

    public function removerItem()
    {
        array_pop($_SESSION['vendas']);

        return header("location: /venda/inserir");
    }

    public function finalizar()
    {
        Manager::connection()->beginTransaction();

        $venda = new Venda;
        $venda->nome = "Venda_" . date('d/m/Y H:m:s');
        $venda->total = $_SESSION['total-vendas'];
        $venda->total_imposto = $_SESSION['impostos-vendas'];

        try {
            $venda->save();
        } catch (\Exception $e) {
            Manager::connection()->rollBack();
            $_SESSION['mensagem'] = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao finalizar venda'];
            return header("location: /venda/inserir");
        }

        foreach ($_SESSION['detalhes-vendas'] as $item) {

            $item['valor'] = str_replace(',', '.', str_replace('.', '', $item['valor']));
            $item['total'] = str_replace(',', '.', str_replace('.', '', $item['total']));
            $item['quantidade'] = str_replace(',', '.', str_replace('.', '', $item['quantidade']));
            $item['total_imposto'] = str_replace(',', '.', str_replace('.', '', $item['total_imposto']));
            $item['percentual_imposto'] = str_replace(',', '.', str_replace('.', '', $item['percentual_imposto']));

            $vendaProduto = new VendaProduto();
            $vendaProduto->valor = $item['valor'];
            $vendaProduto->total = $item['total'];
            $vendaProduto->ven_id = $venda->id;
            $vendaProduto->pro_id = $item['id'];
            $vendaProduto->imposto = $item['percentual_imposto'];
            $vendaProduto->quantidade = $item['quantidade'];
            $vendaProduto->total_imposto = $item['total_imposto'];

            try {
                $vendaProduto->save();
            } catch (\Exception $e) {
                Manager::connection()->rollBack();
                $_SESSION['mensagem'] = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao finalizar venda'];
                return header("location: /venda/inserir");
            }
        }

        try {
            Manager::connection()->commit();
        } catch (\Exception $e) {
            Manager::connection()->rollBack();
            $_SESSION['mensagem'] = ['status' => 'danger', 'titulo' => 'Erro', 'mensagem' => 'Erro ao finalizar vendas'];
            return header("location: /venda/inserir");
        }

        $_SESSION['vendas'] = [];
        $_SESSION['mensagem'] = ['status' => 'success', 'titulo' => 'Sucesso', 'mensagem' => 'Venda finalizada com sucesso'];
        $_SESSION['total-vendas'] = 0;
        $_SESSION['detalhes-vendas'] = [];
        $_SESSION['impostos-vendas'] = 0;

        return header("location: /venda");
    }
}