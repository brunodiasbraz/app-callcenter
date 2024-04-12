<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    use HasFactory;


    // Indicar o nome da tabela
    protected $table = 'telephones';

    // Indicar quais colunas podem ser cadastrada
    protected $fillable =  [
        'ddd',
        'telefone',
        'posicao',

    ];

    public function rules()
    {
        return [
            'ddd' => 'required|max:2|min:2',
            'telefone' => 'required|max:9|min:8'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo é obrigatorio',
            'ddd.min' => 'O nome já existe',
            'telfone.min' => 'O nome deve ter no mínimo 4 caracteres'

        ];
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
