<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InputFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class DialInputFiles extends Command
{
    protected $signature = 'app:dial-input-files';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Obtem os registros da tabela input_files com status pendente
        //$inputFiles = InputFile::where('status', 'pendente')->get();

      // Obtem os registros da tabela input_files com prioridade 1 e status pendente
        $inputFilesPrioridade1 = InputFile::where('prioridade', 1)
        ->where('status', 'pendente')
        ->take(10) // Limita ao máximo de 10 registros
        ->get();

        // Calcula quantos registros ainda são necessários para atingir 10
        $restante = 10 - $inputFilesPrioridade1->count();

        // Se ainda precisarmos de mais registros, obtemos registros com prioridade 2 e status pendente, limitando ao restante necessário
        if ($restante > 0) {
        $inputFilesPrioridade2 = InputFile::where('prioridade', 2)
            ->where('status', 'pendente')
            ->take($restante) // Limita ao restante necessário
            ->get();

        // Adiciona os registros com prioridade 2, se houver
        $inputFilesPrioridade1 = $inputFilesPrioridade1->merge($inputFilesPrioridade2);
        }

        // Resultado final
        $inputFiles = $inputFilesPrioridade1;


        // Verificar se tem registros a serem processados
        if ($inputFiles->isEmpty()) {
            $this->error('Nenhum registro pendente encontrado para processar.');
            return;
        }

        // Iterar sobre os registros e enviar para a rota /include_contact
        foreach ($inputFiles as $inputFile) {
            $response = Http::post(url('/api/include_contact'), [
                'id_campaign' => $inputFile->ivruser_id,
                'phone' => $inputFile->telefone_cliente,
                'pessoa_nome' => $inputFile->nome_cliente,
                
            ]);

            // Verificar se a requisição foi bem-sucedida
            if ($response->successful()) {
                // Atualizar o status do registro para 'processado'
                $inputFile->status = 'processado';
                $inputFile->save();
            } else {
                $this->error('Erro ao enviar registro para a API: ' . $response->status());
            }
        }

        $this->info('Registros pendentes enviados com sucesso para a API.');
    }
}