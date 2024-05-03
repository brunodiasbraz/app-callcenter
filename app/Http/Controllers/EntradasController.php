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
                    // Define as configurações do servidor FTP
                    $ftp_server = '10.100.0.92';
                    $ftp_port = 5021;
                    $ftp_username = 'cemigftp';
                    $ftp_password = 'tel@2020';
                    
                    // Download do arquivo do FTP
                    $temp_file_path = tempnam(sys_get_temp_dir(), 'ftp_file');
                    $ftp_connection = ftp_connect($ftp_server, $ftp_port);
                    
                    if ($ftp_connection) {
                        $login_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);
                        if ($login_result) {
                            // Define o diretório no servidor FTP onde o arquivo será transferido
                            $remote_file = "inputfile/" . $file_info["basename"];

                            // Move o arquivo para o servidor FTP
                            $upload_result = ftp_put($ftp_connection, $remote_file, $file["tmp_name"], FTP_BINARY);
                            if ($upload_result) {
                                echo "Arquivo enviado com sucesso para o servidor FTP.";
                            } else {
                                echo "Erro ao enviar o arquivo para o servidor FTP.";
                            }
                        } else {
                            echo "Erro ao fazer login no servidor FTP.";
                        }

                        // Fecha a conexão FTP
                        ftp_close($ftp_connection);
                    } else {
                        echo "Erro ao conectar ao servidor FTP.";
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
