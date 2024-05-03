<?php

namespace App\Http\Controllers;

use App\Models\ContactReturn;
use App\Http\Requests\StoreContactReturnRequest;
use App\Http\Requests\UpdateContactReturnRequest;
use App\Models\CustomLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactReturnController extends Controller
{

    private $contactReturn;

    public function __construct(ContactReturn $contactReturn)
    {
        $this->contactReturn = $contactReturn;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactreturns = $this->contactReturn->all();
        return response()->json($contactreturns, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $return = DB::connection('mysql_external')->select('SELECT uniqueid, pessoa_codigo, fecha_llamada, failure_cause, failure_cause_txt, discagem_status, ura_digito, duration FROM call_center.calls WHERE migrado_app = 0 AND id_campaign = 2');
        // Por enquanto o campo duração não esta sendo populado - será no populado quando formos para o 78.
        
        try {

            DB::beginTransaction();
    
            $processedIds = [];

            // Verifica se há registros retornados após a consulta
            if (count($return) === 0) {
                Log::info('Todos os registros já foram migrados para o Banco local.');
                return response()->json(['message' => 'Todos os registros ja foram migrados para o Banco local.'], 200);
            }

            foreach ($return as $returnRow) {
                DB::table('contact_returns')->insert([
                    'uniqueid' => $returnRow->uniqueid,
                    'pessoa_codigo' => $returnRow->pessoa_codigo,
                    'data_ultima_tentativa' => $returnRow->fecha_llamada,
                    'discagem_status' => $returnRow->failure_cause,
                    'discagem_status_descricao' => $returnRow->failure_cause_txt,
                    'discagem_status_detalhe' => '0',
                    'discagem_status_detalhe_descricao' => $returnRow->discagem_status,
                    'ura_digitos' => $returnRow->ura_digito,
                    'ura_migrado' => 0,
                    'duracao' => $returnRow->duration,
                    'created_at' => now(),
                ]);
                // Adiciona o ID do registro processado ao array
                $processedIds[] = $returnRow->uniqueid;
            }

            DB::connection('mysql_external')->table('call_center.calls')->whereIn('uniqueid', $processedIds)->update(['migrado_app' => 1]);

            DB::commit();

            return response()->json(['message' => 'Dados salvos no Banco local'], 201);

        } catch (\Exception $e) {
            
            DB::rollBack();

            return response()->json(['message' => 'Erro ao inserir dados' . $e->getMessage()], 500);
        }    
    
    }
    public function return(Request $request)
    {
        // Verificar se existem registros com ura_migrado = 0
        $recordsToMigrate = ContactReturn::where('ura_migrado', '0')->get();
    
        // Se não houver registros para migrar, retornar uma mensagem informando
        if ($recordsToMigrate->isEmpty()) {
            Log::info('Não há registros para migrar.');
            CustomLog::create([
                'content' => 'Não há registros para migrar.',
                'operation' => 'custom'
            ]);
            return response()->json(['message' => 'Não há registros para migrar.'], 404);
        }
    
        try {
            DB::beginTransaction();
    
            $processedIds = [];
            $failedIds = [];
    
            // Iterar sobre cada registro e realizar a requisição POST
            foreach ($recordsToMigrate as $record) {
                $requestData = [
                    "pessoa_codigo" => $record->pessoa_codigo,
                    "data_ultima_tentativa" => $record->data_ultima_tentativa,
                    "discagem_status" => $record->discagem_status,
                    "discagem_status_descricao" => $record->discagem_status_descricao,
                    "discagem_status_detalhe" => $record->discagem_status_detalhe,
                    "discagem_status_detalhe_descricao" => $record->discagem_status_detalhe_descricao,
                    "ura_digitos" => $record->ura_digitos
                ];
    
                // Realizar a requisição POST para a URL especificada
                $response = $this->sendPostRequest($requestData);
                
                
                // Registrar a requisição no banco de dados como um log
                $logContent = 'Requisição POST para o registro ' . $record->id . ': ' . $response['http_code'] . ' - ' . $response['response'];
                CustomLog::create([
                    'content' => $logContent,
                    //'operation' => ($response['http_code'] == 201) ? 'success' : 'error'
                    'operation' => 'custom'
                ]);
    
                // Verificar se a requisição foi bem-sucedida
                if ($response['http_code'] == 201) {
                    // Se sim, adicionar o ID do registro ao array de registros processados
                    $processedIds[] = $record->id;
                } else {
                    // Se não, adicionar o ID do registro ao array de registros com falha
                    $failedIds[] = $record->id;
                }
            }
    
            // Atualizar a coluna ura_migrado de 0 para 1 para os registros processados
            ContactReturn::whereIn('id', $processedIds)
                ->update([
                    'ura_migrado' => 1,
                    'updated_at' => now(),
                ]);
    
            DB::commit();
    
            // Buscar novamente os registros migrados para retorná-los na resposta
            $migratedRecords = ContactReturn::whereIn('id', $processedIds)->get();
    
            return response()->json([
                'message' => 'Dados migrados com sucesso',
                'migrated_records' => $migratedRecords,
                'failed_records' => $failedIds
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            // Em caso de erro, registrar o erro no log
            CustomLog::create([
                'content' => 'Erro ao migrar dados: ' . $e->getMessage(),
                'operation' => 'custom'
            ]);
            return response()->json(['message' => 'Erro ao migrar dados: ' . $e->getMessage()], 500);
        }
    }
    
    // Função para enviar a requisição POST para a URL especificada
    private function sendPostRequest($requestData)
    {
        $url = "http://10.123.68.160:3000/callback-automatico/result-ura";
        $headers = [
            "Authorization: Bearer d2f34c65-b36d-11ed-a908-42010abc0005",
            "Content-Type: application/json",
            "Accept: application/json"
        ];
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        return [
            'response' => $response,
            'http_code' => $httpCode
        ];
    }

    public function show($id)
    {

        $contactreturn = $this->contactReturn->find($id);
        if ($contactreturn === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404); //json
        }
        return response()->json($contactreturn, 200);
    }

    
}