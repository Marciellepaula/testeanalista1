<?php

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
        Schema::create('cupoms', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique()->notNull();
            $table->decimal('desconto_percentual', 5, 2)->notNull();
            $table->decimal('desconto_fixo', 10, 2)->nullable();
            $table->boolean('ativo')->default(true);
            $table->dateTime('data_inicio')->nullable();
            $table->dateTime('data_fim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupoms');
    }
};
