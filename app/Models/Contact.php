<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Indicar o nome da tabela
    protected $table = 'contacts';

    // Indicar quais colunas podem ser cadastrada
    protected $fillable =  [
        'campanha',
        'pessoa_codigo',
        'pessoa_nome',
        'pessoa_cpf',
        'data_agenda',
        'informacoes_extras',
    ];


    public function rules()
    {
        return ['campanha' => 'required|max:80|min:4',];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo é obrigatorio',
            'contacts.unique' => 'O nome já existe',
            'contacts.min' => 'O nome deve ter no mínimo 4 caracteres'

        ];
    }

    public function telephones()
    {
        return $this->hasMany(Telephone::class);
    }
}
