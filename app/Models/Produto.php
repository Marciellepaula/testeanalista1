<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'preco_compra', 'preco_venda', 'categoria', 'quantidade_estoque', 'imagem'];

    public function vendas()
    {
        return $this->belongsToMany(Venda::class)->withPivot('quantidade', 'preco_unitario')->withTimestamps();
    }


    public function categoria()
    {
        return $this->belongs(Categoria::class);
    }
}
