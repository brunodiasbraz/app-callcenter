<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_movimento',
        'contrato_cliente',
        'nome_cliente',
        'telefone_cliente',
        'ocorrencia',
        'data_contato',
        'hora_contato',
    ];
}