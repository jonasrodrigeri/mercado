<?php

namespace App\Models;

use App\Models\TipoProduto;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = "produto";

    public function TipoProduto()
    {
        return $this->hasOne(TipoProduto::class, 'id', 'tpr_id');
    }
}
