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
        Schema::create('dial_customers', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('telefone', 15);
            $table->string('contexto', 30);
            $table->boolean('discado')->default(false);
            $table->boolean('falha')->default(false);
            $table->boolean('tentativa')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dial_customers');
    }
};
