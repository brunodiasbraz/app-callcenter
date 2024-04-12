<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     *     
     * 
     * 
     */

    public function up(): void
    {
        Schema::create('contact_returns', function (Blueprint $table) {
            $table->id();
            $table->string('pessoa_codigo');
            $table->string('data_ultima_tentativa');
            $table->string('discagem_status');
            $table->string('discagem_status_descricao');
            $table->string('discagem_status_detalhe');
            $table->string('discagem_status_detalhe_descricao');
            $table->string('ura_digitos');
            $table->string('duracao');





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_returns');
    }
};
