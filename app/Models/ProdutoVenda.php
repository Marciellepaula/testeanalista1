<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProdutoVenda extends Pivot
{
    use HasFactory;

    protected $fillable = ['venda_id', 'produto_id'];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class)->withTimestamps();
    }


    public function vendas()
    {
        return $this->belongsToMany(Venda::class)->withPivot('preco')->withTimestamps();
    }
}
