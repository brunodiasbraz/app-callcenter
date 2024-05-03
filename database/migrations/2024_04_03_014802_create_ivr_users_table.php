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
            $table->string('user_nome')->nullable();
            $table->string('user_key')->nullable();
            $table->string('token')->nullable();
            $table->string('user_validade')->nullable();
            $table->string('token_validade')->nullable();
            $table->string('acd')->nullable();
            $table->string('retorno_url')->nullable();
            $table->string('retorno_user')->nullable();
            $table->string('retorno_key')->nullable();
            $table->string('retorno_token')->nullable();
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