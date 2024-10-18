<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

    use HasFactory;
    protected $fillable = ['cliente_id', 'total', 'codigo', 'status'];

    public function produtosvenda()
    {
        return $this->hasMany(ProdutoVenda::class);
    }


    public function produtos()
    {
        return $this->belongsToMany(Produto::class)->withPivot('quantidade')->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public static function byCodigo($codigo)
    {
        return self::where('codigo', $codigo)->with(['produtos', 'cliente'])
            ->get();
    }


    public static function vendasAcimaDeTotal($total)
    {
        $vendasAcimaDeMil = self::where('total', '>', $total)->get();
        return response()->json($vendasAcimaDeMil);
    }


    public static function vendaEntreDatas($inicio, $fim)
    {
        return self::whereBetween('created_at', [$inicio, $fim])
            ->get();
    }
}
