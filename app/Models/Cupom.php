<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'desconto_percentual', 'desconto_fixo', 'ativo', 'data_inicio', 'data_fim'];
}
