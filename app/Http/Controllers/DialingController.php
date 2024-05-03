<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DialingController extends Controller
{
    public function index()
    {
        // Recuperar os registros do banco de dados
        $dialing = $this->getDialingData();

        // Carregar a VIEW
        return view('dialing.index', [
            'menu' => 'dialing', 
            'dialing' => $dialing,
            'name' => 'dialing',
        ]);
    }
    
    public function refresh()
    {
        // Recuperar os registros do banco de dados usando a mesma função
        $dialing = $this->getDialingData();

        // Renderizar apenas a parte da tabela e retornar como resposta AJAX
        return view('dialing.table', ['dialing' => $dialing])->render();
    }

    // Função para obter os dados de discagem
    private function getDialingData()
    {
        return DB::connection('mysql_external')
            ->select('SELECT id, status, id_campaign, pessoa_nome, pessoa_cpf, phone, datetime_originate, uniqueid FROM call_center.calls WHERE status = "Placing"');
    }
}

