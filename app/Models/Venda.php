<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

    use HasFactory;
    protected $fillable = ['cliente_id', 'total'];

    public function produtosvenda()
    {
        return $this->hasMany(ProdutoVenda::class);
    }


    public function produtos()
    {
        return $this->belongsToMany(Produto::class)->withPivot('quantidade', 'preco_unitario')->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
