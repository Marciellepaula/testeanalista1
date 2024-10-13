<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VendaProduto extends Pivot
{
    protected $table = 'venda_produto';

    protected $fillable = ['venda_id', 'produto_id', 'quantidade', 'preco_unitario'];
}
