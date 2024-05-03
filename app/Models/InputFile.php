<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputFile extends Model
{
    use HasFactory;

    protected $table = 'input_files';

    protected $fillable = [
        'ivruser_id',
        'data_movimento',
        'contrato_cliente',
        'nome_cliente',
        'telefone_cliente',
        'cpf_cnpj',
        'valor_divida',
        'prioridade',
        'import_status',
        'status',
        'created_at',
        'updated_at',
    ];

    public function contact()
    {
    return $this->belongsTo(IvrUser::class);
    }

}