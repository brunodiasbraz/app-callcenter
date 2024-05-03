<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;


class RamaisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:index-ramais', ['only' => ['index']]);
        $this->middleware('permission:create-ramais', ['only' => ['create','store', 'edit']]);
        $this->middleware('permission:destroy-ramais', ['only' => ['destroy']]);

    }
    public function show(Request $request)
    {    

        // Salvar log
        //Log::info('Listar as páginas', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('ramais.show', ['menu' => 'ramais']);
    }

    public function index(Request $request){

        $ramais = DB::connection('pgsql_asterisk')->select("SELECT pe.id, pe.context, pe.disallow, pe.allow, pe.direct_media, pa.password, 
                                                            CASE 
                                                                WHEN pc.endpoint IS NULL THEN 'deslogado' 
                                                                ELSE 'logado' 
                                                            END AS status
                                                            FROM 
                                                                public.ps_endpoints pe
                                                            JOIN 
                                                                public.ps_auths pa ON pe.id = pa.id
                                                            LEFT JOIN 
                                                                public.ps_contacts pc ON pe.id = pc.endpoint 
                                                            WHERE 
                                                                LENGTH(pe.id) = 4 ORDER BY pe.id ASC;
                                                            ");

        Log::info('Listar ramais.', ['action_user_id' => Auth::id()]);

        return view('ramais.index', [
            'menu' => 'ramais',
            'title' => $request->title,
            'name' => $request->name,
            'ramais' => $ramais,
        ]);
      }

    public function create(Request $request){

        return view('ramais.create', [
            'menu' => 'ramais',
        ]);

    }
    public function store(Request $request){
        // Validação dos dados recebidos do formulário
        $request->validate([
            'ramal' => 'required|numeric', // Exemplo de validação para o campo 'ramal'
        ]);

        $id = $request->ramal;
        $context = $request->context; 
        $password = $request->secretRamal;
        $maxContacts = $request->maxContacts;

        DB::beginTransaction();
        
        try {

            DB::connection('pgsql_asterisk')->table('public.ps_aors')->insert([
                'id' => $id,
                'max_contacts' => $maxContacts,
            ]);
    
            DB::connection('pgsql_asterisk')->table('public.ps_auths')->insert([
                'id' => $id,
                'auth_type' => 'userpass',
                'password' => $password,
                'username' => $id,
            ]);
        
            DB::connection('pgsql_asterisk')->table('public.ps_endpoints')->insert([
                'id' => $id,
                'transport' => 'transport-udp',
                'aors' => $id,
                'auth' => $id,
                'context' => $context,
                'disallow' => 'all',
                'allow' => 'alaw,ulaw,opus',
                'direct_media' => 'no'
            ]);

            DB::commit();
        
            // Redirecionar de volta para a página inicial com uma mensagem de sucesso
            return redirect()->route('ramais.index')->with('success', 'Ramal cadastrado com sucesso!');
        
        } catch (Exception $e){
            
            return redirect()->route('ramais.index')->with('error', 'Ocorreu um erro ao cadastrar o ramal: ' . $e->getMessage());
        }
    }
    public function edit(Request $request){

        $id = $request->ramal;
        $context = $request->context; 
        $password = $request->secretRamal;
        $maxContacts = $request->maxContacts;

        DB::beginTransaction();
        
        try {

             DB::connection('pgsql_asterisk')->table('public.ps_aors')
                ->where('id', $id)
                ->update(['max_contacts' => $maxContacts]);
    
            DB::connection('pgsql_asterisk')->table('public.ps_auths')
                ->where('id', $id)
                ->update(['auth_type' => 'userpass',
                        'password' => $password,
                        'username' => $id,
            ]);
        
            DB::connection('pgsql_asterisk')->table('public.ps_endpoints')
                ->where('id', $id)
                ->update(['transport' => 'transport-udp',
                'aors' => $id,
                'auth' => $id,
                'context' => $context,
                'disallow' => 'all',
                'allow' => 'alaw,ulaw,opus',
                'direct_media' => 'no'
            ]);

            DB::commit();
           //var_dump('Ramal: '.$id, 'context: '.$context, 'password: '.$password, 'maxContacts: '.$maxContacts,);
            // Redirecionar de volta para a página inicial com uma mensagem de sucesso
            return redirect()->route('ramais.index')->with('success', 'Ramal editado com sucesso!');
        
        } catch (Exception $e){
            DB::rollBack();
            return redirect()->route('ramais.index')->with('error', 'Ocorreu um erro ao editar o ramal: ' . $e->getMessage());
        }
    }
    
    public function destroy($id){

        DB::beginTransaction();
        
        try {

            DB::connection('pgsql_asterisk')->table('public.ps_aors')->where('id', $id)->delete();
            DB::connection('pgsql_asterisk')->table('public.ps_auths')->where('id', $id)->delete();
            DB::connection('pgsql_asterisk')->table('public.ps_endpoints')->where('id', $id)->delete();
    
            
            DB::commit();
            //var_dump('Ramal: '.$id, 'context: '.$context, 'password: '.$password, 'maxContacts: '.$maxContacts,);
            // Redirecionar de volta para a página inicial com uma mensagem de sucesso
            return redirect()->route('ramais.index')->with('success', 'Ramal excluído com sucesso!');
        
        } catch (Exception $e){
            DB::rollBack();
            return redirect()->route('ramais.index')->with('error', 'Ocorreu um erro ao excluir o ramal: ' . $e->getMessage());
        }
    }

}
