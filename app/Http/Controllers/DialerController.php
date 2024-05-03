<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PAMI\Client\Impl\ClientImpl as PamiClient;
use PAMI\Message\Action\OriginateAction;
use PAMI\Message\Action\LogoffAction;

class DialerController extends Controller
{
    public function dialer()
    {
        // Configuração para conexão com o manager do Asterisk
        $pamiClientOptions = [
            'host' => '10.100.0.78',
            'scheme' => 'tcp://',
            'port' => 5038,
            'username' => 'interactx',
            'secret' => 'interactx123',
            'connect_timeout' => 10000,
            'read_timeout' => 10000
        ];

        // Instancia a conexão
        $client = new PamiClient($pamiClientOptions);
        $client->open();

        // Abre o arquivo CSV
        $csvFile = base_path('discagem.csv'); // Caminho para o arquivo CSV na raiz do projeto
        $csvData = fopen($csvFile, 'r');

        $a = 1;
        while ($row = fgetcsv($csvData)) {
            echo "Ligação número ".$a." para a pessoa ".$row[0]." no número ".$row[1]."\n";

            // Configura Originate
            $action = new OriginateAction('local/'.$row[1] .'@saida');
            $action->setContext('saida');
            $action->setApplication('Playback');
            $action->setData('tt-monkeys');

            // Envia a ação
            $client->send($action);

            $a++;
            sleep(10);
        }

        // Fecha o arquivo CSV e a conexão com o Asterisk
        fclose($csvData);
        $client->close();

        return "Ligações concluídas.";
    }

    public function includeContact_hml(Request $request)
    {
        $requestData = $request->all();
        
        $id_campaign = $requestData['id_campaign'];
        $phone = $requestData['phone'];
        //$pessoa_codigo = $requestData['pessoa_codigo'];
        $pessoa_nome = $requestData['pessoa_nome'];
        //$pessoa_cpf = $requestData['pessoa_cpf'];
        
        try {
            // Realiza a inserção no banco de dados externo
            DB::connection('mysql_external')->table('call_center.calls')->insert([
                'id_campaign' => $id_campaign,
                //'pessoa_codigo' => $pessoa_codigo,
                'pessoa_nome' => $pessoa_nome,
                //'pessoa_cpf' => $pessoa_cpf,
                'phone' => $phone
            ]);

            // Atualiza o status da campanha
            DB::connection('mysql_external')->table('campaign')->where('id', $id_campaign)->update(['estatus' => 'A']);

            return response()->json(['msg' => 'Dados inseridos com sucesso', 'cod' => 201], 201);
        } catch (\Exception $e) {
            // Em caso de erro, retorna uma resposta de erro
            return response()->json(['msg' => 'Erro ao inserir dados: ' . $e->getMessage()], 500);
        }
    }
}