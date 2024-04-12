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
        Schema::create('ivr_users', function (Blueprint $table) {
            $table->id();
            $table->string('user_nome');
            $table->string('user_key');
            $table->string('token');
            $table->string('user_validade');
            $table->string('token_validade');
            $table->string('acd');
            $table->string('retorno_url');
            $table->string('retorno_user');
            $table->string('retorno_key');
            $table->string('retorno_token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ivr_users');
    }
};
