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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('campanha', 80);
            $table->string('pessoa_codigo', 100);
            $table->string('pessoa_nome', 100);
            $table->string('pessoa_cpf', 15);
            $table->string('pessoa_telefone', 12)->nullable();
            $table->string('data_agenda', 20);
            $table->string('informacoes_extras', 255);
            $table->string('user_nome', 30)->nullable();
            $table->string('valor_divida', 30)->nullable();
            $table->string('prioridade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
