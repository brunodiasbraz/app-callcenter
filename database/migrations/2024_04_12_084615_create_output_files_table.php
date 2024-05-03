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
        Schema::create('output_files', function (Blueprint $table) {
            $table->id();
            $table->string('data_movimento');
            $table->string('contrato_cliente');
            $table->string('nome_cliente');
            $table->string('telefone_cliente');
            $table->string('ocorrencia')->nullable();
            $table->string('data_contato')->nullable();
            $table->string('hora_contato')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('output_files');
    }
};