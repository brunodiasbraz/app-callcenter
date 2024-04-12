<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\CustomLog;
use App\Models\Telephone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{

    // protected $contact;
    // protected $telephone;
    protected $custom_log;

    public function __construct(Contact $contact, Telephone $telephone, Customlog $custom_log)
    {
        //$this->contact = $contact;
        //$this->telephone = $telephone;
        $this->custom_log = $custom_log;
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials))
            abort(401, 'Invalid Credentials');

        // $token = $user->createToken('auth_token')->plainTextToken;
        $token = auth()->user()->createToken('auth_token'); //->plainTextToken;

        return response()->json([

            'data' => [
                'token' => $token->plainTextToken
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'me' => $user,
        ]);
    }

    public function register(Request $request, User $user)
    {
        $userData = $request->only('name', 'email', 'password');
        $userData['password'] = bcrypt($userData['password']);

        if (!$user = $user->create($userData))
            abort(500, 'Erro para criar novo user');


        return response()->json([

            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function store(Request $request)
    {

        // O usuário estará autenticado automaticamente se o middleware for bem sucedido
        $user = auth()->user();

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
}
