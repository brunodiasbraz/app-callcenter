<?php

namespace App\Http\Controllers;

use App\Models\InputFile;
use App\Models\IvrUser;
use App\Http\Requests\StoreInputFileRequest;
use App\Http\Requests\UpdateInputFileRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ErrorNotification;
use Database\Factories\InputFileFactory;

class InputFileController extends Controller
{
        public function importFileFromFTP(Request $request, $id_campaign)
        {
            $current_date = date('Ymd');
            $mailing_file_name = "URAA01.$current_date.csv";

            // Conexão FTP
            $ftp_server = '10.100.0.92';
            $ftp_port = 5021;
            $ftp_username = 'cemigftp';
            $ftp_password = 'tel@2020';
            $ftp_file_path = "inputfile/$mailing_file_name";

            // Download do arquivo do FTP
            $temp_file_path = tempnam(sys_get_temp_dir(), 'ftp_file');
            $ftp_connection = ftp_connect($ftp_server, $ftp_port);
            $login_result = ftp_login($ftp_connection, $ftp_username, $ftp_password);

            //var_dump($ftp_connection);

            if ($ftp_connection && $login_result) {
                if (ftp_get($ftp_connection, $temp_file_path, $ftp_file_path, FTP_BINARY)) {
                    // Importar o arquivo para o banco de dados
                    $file_content = file($temp_file_path, FILE_IGNORE_NEW_LINES);
                    
                    //unset($file_content[0]);
                    
                            foreach ($file_content as $line) {
                                // Explodir a linha usando tanto ',' quanto ';' como delimitadores
                                $fields = preg_split("/[,;]/", $line);
                                if (count($fields) === 7) {
                                    // Buscar o usuário correspondente pelo campo 'acd'
                                    $ivrUser = IvrUser::where('acd', $id_campaign)->first();
                                    // Verificar se o usuário foi encontrado
                                    if ($ivrUser) {
                                        InputFile::create([
                                            'ivruser_id' => $ivrUser->id,
                                            'data_movimento' => $fields[0],
                                            'contrato_cliente' => $fields[1],
                                            'nome_cliente' => $fields[2],
                                            'telefone_cliente' => $fields[3],
                                            'cpf_cnpj' => $fields[4],
                                            'valor_divida' => $fields[5],
                                            'prioridade' => $fields[6],
                                            'import_status' => 'imported', // Campo para status de importação
                                            'status' => 'pendente',
                                        ]);

                        } else {
                            $error_message = 'Erro: o formato da linha não corresponde ao esperado';
                            // Se houver um erro em uma linha, não é necessário continuar a importação
                            // Interromper o loop e enviar notificação de erro
                            break;
                        }
                    }
                }

                    // Verificar se todas as linhas foram inseridas com sucesso
                    $total_lines_in_file = count($file_content);
                    $total_records_in_database = InputFile::where('import_status', 'imported')->count();

                    if ($total_records_in_database === $total_lines_in_file) {
                        return response()->json(['success' => true, 'message' => 'Arquivo importado com sucesso']);
                    } else {
                        $error_message = 'Não foi possível inserir todas as linhas do arquivo no banco de dados';
                    }
                } else {
                    $error_message = 'Erro ao baixar o arquivo do FTP';
                }
            } else {
                $error_message = 'Erro na conexão FTP';
            }

            // Se houver algum erro, enviar notificação por email e telegram
           // Mail::to('seu-email@example.com')->send(new ErrorNotification($error_message));

            return response()->json(['success' => false, 'message' => $error_message], 500);
        }
    }