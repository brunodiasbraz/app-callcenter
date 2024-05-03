<?php

use App\Models\IvrUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.•	
     * 
     */
    public function up(): void
    {
        Schema::create('input_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ivruser_id');
            $table->foreign('ivruser_id')->references('id')->on('ivr_users')->onDelete('cascade');
            $table->string('data_movimento');
            $table->string('contrato_cliente');
            $table->string('nome_cliente');
            $table->string('telefone_cliente');
            $table->string('cpf_cnpj');
            $table->string('valor_divida');
            $table->string('prioridade');
            $table->string('import_status');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_files');
    }
};