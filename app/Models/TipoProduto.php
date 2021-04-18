<?php

namespace App\Models;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    protected $table = "tipo_produto";

    public function Produto()
    {
        return $this->belongsTo(Produto::class, 'tpr_id', 'id');
    }
}
