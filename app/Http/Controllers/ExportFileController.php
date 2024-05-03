<?php

namespace App\Http\Controllers;

use App\Models\ExportFile;
use App\Http\Requests\StoreExportFileRequest;
use App\Http\Requests\UpdateExportFileRequest;

use App\Models\SeuModelo; // Substitua 'SeuModelo' pelo nome do seu modelo
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ExportFileController extends Controller
{

    public function exportData()
    {
        $currentHour = Carbon::now()->hour; // Obter a hora atual

        // Verificar se é após as 10h
        if ($currentHour >= 10) {
            $highPriorityData = ExportFile::where('prioridade', 'alta')->get();
            $lowPriorityData = ExportFile::where('prioridade', 'baixa')->get();
        } else {
            $highPriorityData = ExportFile::where('prioridade', 'alta')->get();
            $lowPriorityData = collect(); // Coleção vazia para prioridade baixa
        }

        $this->processData($highPriorityData, true); // Processar dados de alta prioridade primeiro
        $this->processData($lowPriorityData, false); // Processar dados de baixa prioridade depois
    }

    private function processData($data, $isHighPriority)
    {
        $chunkedData = $data->chunk(50); // Dividir os dados em pedaços de 50

        foreach ($chunkedData as $chunk) {
            $json = $chunk->toJson(); // Converta o pedaço de dados para JSON

            // Se o número de registros for menor que 50 e for alta prioridade, complete com baixa prioridade
            if ($isHighPriority && $chunk->count() < 50) {
                $missingCount = 50 - $chunk->count();
                $lowPriorityToAdd = ExportFile::where('prioridade', 'baixa')->take($missingCount)->get();
                $chunk = $chunk->concat($lowPriorityToAdd);
            }

            // Envie o JSON para a URL
            $response = Http::post('sua/url/aqui', ['data' => $chunk->toJson()]);

            // Verifique o status da resposta
            if ($response->successful()) {
                // Sucesso
            } else {
                // Se houver um erro, envie por email ou telegram
                Mail::raw('Houve um erro ao enviar os dados: ' . $response->status(), function ($message) {
                    $message->to('seu@email.com')
                            ->subject('Erro ao exportar dados');
                });
            }
        }
    }
}
