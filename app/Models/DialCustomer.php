<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DialCustomer extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'telefone', 'contexto', 'discado', 'falha', 'tentativa'];
}
