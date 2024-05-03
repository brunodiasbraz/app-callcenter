<?php

namespace App\Http\Controllers;

use App\Models\Telephone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DialQueueController extends Controller
{
    public function index()
{
    // Busca os telefones do modelo Telephone com os campos especificados
    $telephones = Telephone::select('ddd', 'telefone as phone')->get();
    
    // Transforma os telefones em um formato desejado
    $formattedTelephones = [];
    foreach ($telephones as $telephone) {
        $formattedTelephones[] = [
            'id_campaign' => '2',
            'pessoa_codigo' => '12345678912',
            'pessoa_nome' => 'Ti Bruno',
            'phone' => $telephone->ddd . $telephone->phone // Concatena ddd e telefone
        ];
    }
    
    try {
        // Cria uma requisição HTTP POST para a URL especificada com verificação SSL desabilitada
        $response = Http::withoutVerifying()->post('https://10.100.0.88/api/include_call', $formattedTelephones);
        
        // Verifica se a requisição foi bem-sucedida e retorna a resposta
        if ($response->successful()) {
            return $response->json();
        } else {
            // Se a requisição falhou, retorne uma resposta de erro ou faça o tratamento adequado
            return response()->json(['error' => 'Failed to send data to the URL'], 500);
        }
    } catch (ConnectionException $e) {
        // Se ocorrer um erro de conexão, retorne uma resposta de erro
        return response()->json(['error' => 'Connection error: ' . $e->getMessage()], 500);
    }
}
}
