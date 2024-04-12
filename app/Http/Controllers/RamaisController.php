<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

$host = "localhost";
$user = "asterisk";
$pass = "tel@2020";
$base = "asterisk";

$conn = mysqli_connect ($host,$user,$pass,$base);

if (mysqli_connect_errno()) {
// echo "Erro na Conexao ao  MySQL: " . mysqli_connect_error();
}else{
    //echo "conexão com o banco efetuada com sucesso";
}

class RamaisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:index-ramais', ['only' => ['index']]);
        $this->middleware('permission:create-ramais', ['only' => ['create','store']]);

    }

    public function index(Request $request)
    {


        // Salvar log
        //Log::info('Listar as páginas', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('ramais.index', [
            'menu' => 'ramais',
            'title' => $request->title,
            'name' => $request->name,
        ]);
    }
    public function show(Request $request)
    {
        $host = "localhost";
        $user = "asterisk";
        $pass = "tel@2020";
        $base = "asterisk";

        $conn = mysqli_connect ($host,$user,$pass,$base);

        if (mysqli_connect_errno()) {
        // echo "Erro na Conexao ao  MySQL: " . mysqli_connect_error();
        }else{
            //echo "conexão com o banco efetuada com sucesso";
        }

        

        // Salvar log
        //Log::info('Listar as páginas', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('ramais.show', ['menu' => 'ramais']);
    }

    public function create(Request $request){

        $host = "localhost";
        $user = "asterisk";
        $pass = "tel@2020";
        $base = "asterisk";

        $conn = mysqli_connect ($host,$user,$pass,$base);

        if (mysqli_connect_errno()) {
        // echo "Erro na Conexao ao  MySQL: " . mysqli_connect_error();
        }else{
            //echo "conexão com o banco efetuada com sucesso";
        }

        $ramal_sip = $request->input('ramal_sip');
        $senha_ramal_sip = $request->input('senha_ramal_sip');
        $contexto_ramal_sip = $request->input('contexto_ramal_sip');
        $dinamic_static_ramal_sip = $request->input('dinamic_static_ramal_sip');
      
        
        // Verifica se já existe um registro com o mesmo nome
        $duplicate = mysqli_query($conn, "SELECT COUNT(*) as total FROM sippeers WHERE name = '$ramal_sip'");
        $row = mysqli_fetch_assoc($duplicate);
        if ($row['total'] > 0) {
            mysqli_close($conn);
            return back()->withInput()->with('error', 'Já existe um ramal com esse nome!');
        }

        // Se não houver registro com o mesmo nome, insira o novo registro
        $sql = "INSERT INTO sippeers (name, secret, context, host) VALUES ('$ramal_sip', '$senha_ramal_sip', '$contexto_ramal_sip', '$dinamic_static_ramal_sip')";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return redirect()->route('ramais.index')->with('success', 'Ramal cadastrado com sucesso!');
        } else {
            mysqli_close($conn);
            return back()->withInput()->with('error', 'Erro ao cadastrar ramal!');
        }

    }

}
