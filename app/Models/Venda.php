<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

    use HasFactory;
    protected $fillable = ['cliente_id', 'total', 'codigo', 'status', 'quantidade'];

    public function produtosvenda()
    {
        return $this->hasMany(ProdutoVenda::class);
    }


    public function produtos()
    {
        return $this->belongsToMany(Produto::class)->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function scopeByCodigo($query, $codigo)
    {
        return $query->where('codigo', $codigo);
    }

    public function scopeVendasAcimaDeTotal($query, $total)
    {
        return $query->where('total', '>', $total);
    }

    public function scopeVendaEntreDatas($query, $startDate, $endDate)
    {

        $startDate = DateTime::createFromFormat('Y-m-d', $startDate)->format('Y-m-d H:i:s');
        $endDate = DateTime::createFromFormat('Y-m-d', $endDate)->format('Y-m-d H:i:s');
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }
}
