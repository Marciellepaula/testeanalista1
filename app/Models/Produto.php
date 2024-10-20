<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao', 'preco_compra', 'preco_venda', 'categoria_id', 'quantidade_estoque', 'imagem',];

    public function vendas()
    {
        return $this->belongsToMany(Venda::class)->withPivot('quantidade', 'total')->withTimestamps();
    }


    public function categoria()
    {
        return $this->belongs(Categoria::class);
    }
}
