<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IvrUser extends Model
{
    use HasFactory;

    // Indicar o nome da tabela
    protected $table = 'ivr_users';

    protected $fillable = [
                    'user_nome',
                    'user_key',
                    'token',
                    'user_validade',
                    'token_validade',
                    'acd',
                    'retorno_url',
                    'retorno_user',
                    'retorno_key',
                    'retorno_token',
    ];

    public function input_files()
    {
        return $this->hasMany(InputFile::class);
    }
}