<?php

use App\Models\Produto;
use App\Models\Venda;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('venda_produto', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Produto::class);
            $table->foreignIdFor(Venda::class);
            $table->integer('quantidade');
            $table->decimal('preco', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venda_produto');
    }
};
