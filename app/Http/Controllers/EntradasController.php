<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntradasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:index-entradas', ['only' => ['index']]);

    }

    public function index(Request $request)
    {


        // Salvar log
        //Log::info('Listar as páginas', ['action_user_id' => Auth::id()]);

        // Carregar a VIEW
        return view('entradas.index', [
            'menu' => 'entradas',
            'title' => $request->title,
            'name' => $request->name,
        ]);
    }

    public function upload(Request $request)
    {
        if (isset($_FILES["file"])) {
            $file = $_FILES["file"];

            // Verifica se não houve erro durante o envio do arquivo
            if ($file["error"] === UPLOAD_ERR_OK) {
                // Verifica se é um arquivo CSV
                $file_info = pathinfo($file["name"]);
                if (strtolower($file_info["extension"]) === "csv") {
                    // Lê o conteúdo do arquivo CSV
                    $csv_data = file_get_contents($file["tmp_name"]);
                    if ($csv_data !== false) {
                        // Divide o conteúdo do CSV em linhas
                        $lines = explode("\n", $csv_data);

                        // Remove a primeira linha (cabeçalho)
                        unset($lines[0]);

                        // Inicializa um array para armazenar os objetos JSON
                        $json_objects = array();

                        // Itera sobre as linhas do CSV
                        foreach ($lines as $line) {
                            // Verifica se a linha não está vazia
                            if (trim($line) !== "") {
                                // Divide a linha em colunas
                                $columns = explode(",", $line);

                                // Cria um objeto JSON com as colunas
                                $json_object = array(
                                    "id_campaign" => trim($columns[0]),
                                    "pessoa_codigo" => trim($columns[1]),
                                    "pessoa_nome" => trim($columns[2]),
                                    "phone" => trim($columns[3])
                                );

                                // Adiciona o objeto JSON ao array
                                $json_objects[] = $json_object;
                            }
                        }

                        // Converte o array de objetos JSON em JSON
                        $json_data = json_encode($json_objects);

                        // Envia os dados JSON para o endpoint via POST
                        $endpoint_url = "https://10.100.0.88/api/include_call/";
                        $curl = curl_init($endpoint_url);
                        curl_setopt($curl, CURLOPT_POST, 1);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

                        $response = curl_exec($curl);

                        // Verifica se houve erro na requisição
                        if ($response === false) {
                            echo "Erro na requisição: " . curl_error($curl);
                        } else {
                            // Exibe a resposta do endpoint
                            echo $response;
                        }

                        // Fecha a requisição cURL
                        curl_close($curl);
                    } else {
                        echo "Erro ao ler o arquivo CSV.";
                    }
                } else {
                    echo "Por favor, envie um arquivo CSV.";
                }
            } else {
                echo "Erro ao enviar o arquivo.";
            }
        }
    }
}
