<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactReturn extends Model
{
    use HasFactory;

    protected $table = 'contact_returns';

    protected $fillable = [
        'uniqueid',
        'pessoa_codigo',
        'data_ultima_tentativa',
        'discagem_status',
        'discagem_status_descricao',
        'discagem_status_detalhe',
        'discagem_status_detalhe_descricao',
        'ura_digitos',
        'duracao',
        'ura_migrado',
        'created_at',
        'updated_at',
    ];

    public function contact_return() {
        return $this->belongsTo(Contact::class);
    }
}
