<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\CustomLog;
use App\Models\Telephone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;


class ContactController extends Controller
{
    protected $contact;
    protected $telephone;
    protected $custom_log;

    public function __construct(Contact $contact, Telephone $telephone, Customlog $custom_log)
    {
        $this->contact = $contact;
        $this->telephone = $telephone;
        $this->custom_log = $custom_log;
    }

    public function index()
    {
        $contacts = $this->contact->all();
        return response()->json($contacts, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage. StoreContactRequest
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        try {
            // Inicia uma transação
            DB::beginTransaction();

            $contact = Contact::create([
                'campanha' => $requestData['campanha'],
                'pessoa_codigo' => $requestData['pessoa_codigo'],
                'pessoa_nome' => $requestData['pessoa_nome'],
                'pessoa_cpf' => $requestData['pessoa_cpf'],
                'data_agenda' => $requestData['data_agenda'],
                'informacoes_extras' => $requestData['informacoes_extras'],
            ]);

            foreach ($requestData['telefones'] as $telefone) {
                // Obtém o número total de telefones encaminhados para o contato atual
                $posicao = $contact->telephones()->count();

                // Cria um novo telefone com a posição correta
                $contact->telephones()->create([
                    'ddd' => $telefone['ddd'],
                    'telefone' => $telefone['telefone'],
                    'posicao' => $posicao,
                ]);
            }

            // Commit na transação
            DB::commit();

            // Grava um log personalizado de sucesso
            $this->custom_log->create([
                'content' => 'Dados inseridos com sucesso',
                'operation' => 'store'
            ]);

            return response()->json(['msg' => 'Dados inseridos com sucesso', 'cod' => 201], 201);
        } catch (\Exception $e) {
            // Rollback da transação em caso de erro
            DB::rollBack();

            // Grava um log personalizado de erro
            $this->custom_log->create([
                'content' => 'Erro ao inserir dados: ' . $e->getMessage(),
                'operation' => 'store'
            ]);
            return response()->json(['message' => 'Erro ao inserir dados'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = $this->contact->find($id);
        if ($contact === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe', 'cod' => 404], 404); //json
        }
        return response()->json($contact, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
