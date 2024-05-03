<?php

namespace App\Http\Controllers;

use App\Jobs\DialingJob;
use Illuminate\Http\Request;
use PAMI\Client\Impl\ClientImpl as PamiClient;
use PAMI\Message\Action\OriginateAction;
use App\Models\DialCustomer;



class DialCustomerController extends Controller
{
    public function dialer()
    {
        // Obter todos os clientes do banco de dados
        $clientes = DialCustomer::all();

        foreach ($clientes as $cliente) {
            // Criar um novo registro de discagem no banco de dados
            $cliente->discado = false;
            $cliente->falha = false;
            $cliente->tentativa = false;
            $cliente->save();
        }

        // Despachar o job para processar os registros de discagem
        DialingJob::dispatch();

        return "Discagem iniciada. Por favor, aguarde o processamento em segundo plano.";
    }
}