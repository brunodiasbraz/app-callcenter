<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    // Executar o construct quando instanciar a classe
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:index-user', ['only' => ['index']]);
        $this->middleware('permission:show-user', ['only' => ['show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:edit-user-password', ['only' => ['editPassword', 'updatePassword']]);
        $this->middleware('permission:destroy-user', ['only' => ['destroy']]);
        $this->middleware('permission:generate-pdf-user', ['only' => ['generatePdf']]);
    }

    // Listar os usuários
    public function index(Request $request)
    {

        // Recuperar os registros do banco dados
        $users = User::when($request->has('name'), function ($whenQuery) use ($request) {
            $whenQuery->where('name', 'like', '%' . $request->name . '%');
        })
            ->when($request->has('email'), function ($whenQuery) use ($request) {
                $whenQuery->where('email', 'like', '%' . $request->email . '%');
            })
            ->when($request->filled('data_cadastro_inicio'), function ($whenQuery) use ($request) {
                $whenQuery->where('created_at', '>=', \Carbon\Carbon::parse($request->data_cadastro_inicio)->format('Y-m-d H:i:s'));
            })
            ->when($request->filled('data_cadastro_fim'), function ($whenQuery) use ($request) {
                $whenQuery->where('created_at', '<=', \Carbon\Carbon::parse($request->data_cadastro_fim)->format('Y-m-d H:i:s'));
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Salvar log
        Log::info('Listar usuários.', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('users.index', [
            'menu' => 'users',
            'users' => $users,
            'name' => $request->name,
            'email' => $request->email,
            'data_cadastro_inicio' => $request->data_cadastro_inicio,
            'data_cadastro_fim' => $request->data_cadastro_fim,
        ]);
    }

    // Detalhes do usuario
    public function show(User $user)
    {

        // Salvar log
        Log::info('Visualizar usuário.', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('users.show', ['menu' => 'users', 'user' => $user]);
    }

    // Carregar o formulário cadastrar novo usuário
    public function create()
    {

        // Recuperar os papéis
        $roles = Role::pluck('name')->all();

        // Salvar log
        Log::info('Carregar formulário cadastrar usuário.', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('users.create', [
            'menu' => 'users',
            'roles' => $roles,
        ]);
    }

    // Cadastrar no banco de dados o novo curso
    public function store(UserRequest $request)
    {

        // Validar o formulário
        $request->validated();

        // Marca o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Cadastrar no banco de dados na tabela usuários
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Cadastrar papel para o usuário
            $user->assignRole($request->roles);

            // Salvar log
            Log::info('Usuário cadastrado.', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Operação é concluída com êxito
            DB::commit();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::warning('Usuário não cadastrado.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não é concluída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    // Carregar o formulário editar usuário
    public function edit(User $user)
    {

        // Recuperar os papéis
        $roles = Role::pluck('name')->all();

        // Recuperar o papel do usuário
        $userRoles = $user->roles->pluck('name')->first();

        // Salvar log
        Log::info('Carregar formulário editar usuário.', ['id' => $user->id, 'action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('users.edit', [
            'menu' => 'users',
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    // Editar no banco de dados o usuário
    public function update(UserRequest $request, User $user)
    {

        // Validar o formulário
        $request->validated();

        // Marca o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Editar o papel do usuário
            $user->syncRoles($request->roles);

            // Salvar log
            Log::info('Usuário editado.', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Operação é concluída com êxito
            DB::commit();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $request->user])->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::warning('Usuário não editado.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não é concluída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }

    // Carregar o formulário editar senha do usuário
    public function editPassword(User $user)
    {

        // Salvar log
        Log::info('Carregar formulário editar senha do usuário.', ['id' => $user->id, 'action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('users.editPassword', ['menu' => 'users', 'user' => $user]);
    }

    // Editar no banco de dados a senha do usuário
    public function updatePassword(Request $request, User $user)
    {

        // Validar o formulário
        $request->validate([
            'password' => 'required|min:6',
        ], [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ]);

        // Marca o ponto inicial de uma transação
        DB::beginTransaction();

        try {

            // Editar as informações do registro no banco de dados
            $user->update([
                'password' => $request->password,
            ]);

            // Salvar log
            Log::info('Senha do usuário editada.', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Operação é concluída com êxito
            DB::commit();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $request->user])->with('success', 'Senha do usuário editada com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::warning('Senha do usuário não editada.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Operação não é concluída com êxito
            DB::rollBack();

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Senha do usuário não editada!');
        }
    }

    // Excluir o usuário do banco de dados
    public function destroy(User $user)
    {
        try {
            // Excluir o registro do banco de dados
            $user->delete();

            // Remove todos os papéis atribuídos ao usuário
            $user->syncRoles([]);

            // Salvar log
            Log::info('Usuário excluído.', ['id' => $user->id, 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso!');
        } catch (Exception $e) {

            // Salvar log
            Log::warning('Usuário não excluído.', ['error' => $e->getMessage(), 'action_user_id' => Auth::id()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('course.index')->with('error', 'Usuário não excluído!');
        }
    }

    // Gerar PDF
    public function generatePdf(Request $request)
    {

        // Recuperar os registros do banco dados
        //$users = User::orderByDesc('id')->get();

        $users = User::when($request->has('name'), function ($whenQuery) use ($request) {
            $whenQuery->where('name', 'like', '%' . $request->name . '%');
        })
            ->when($request->has('email'), function ($whenQuery) use ($request) {
                $whenQuery->where('email', 'like', '%' . $request->email . '%');
            })
            ->when($request->filled('data_cadastro_inicio'), function ($whenQuery) use ($request) {
                $whenQuery->where('created_at', '>=', \Carbon\Carbon::parse($request->data_cadastro_inicio)->format('Y-m-d H:i:s'));
            })
            ->when($request->filled('data_cadastro_fim'), function ($whenQuery) use ($request) {
                $whenQuery->where('created_at', '<=', \Carbon\Carbon::parse($request->data_cadastro_fim)->format('Y-m-d H:i:s'));
            })
            ->orderByDesc('id')
            ->get();

        // Somar total de registros
        $totalRecords = $users->count('id');

        // Verificar se a quantidade de registros ultrapassa o limite para gerar PDF
        if($totalRecords > 500){

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('user.index', [
                'name' => $request->name,
                'email' => $request->email,
                'data_cadastro_inicio' => $request->data_cadastro_inicio,
                'data_cadastro_fim' => $request->data_cadastro_fim,
            ])->with('error', 'Limite de registros ultrapassado para gerar PDF!');
        }

        // Carregar a string com o HTML/conteúdo e determinar a orientação e o tamanho do arquivo
        $pdf = PDF::loadView('users.generate-pdf', ['users' => $users])->setPaper('a4', 'portrait');

        // Fazer o download do arquivo
        return $pdf->download('list_users.pdf');
    }
}
