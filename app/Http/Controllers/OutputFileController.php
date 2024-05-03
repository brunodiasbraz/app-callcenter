<?php

namespace App\Http\Controllers;

use App\Models\InputFile;
use App\Models\OutputFile;
use App\Http\Requests\StoreoutputFileRequest;
use App\Http\Requests\UpdateoutputFileRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Mail\ErrorNotification;


class OutputFileController extends Controller
{

    public function generateAndUploadTxtFile()
    {
        try {
            // Pegar os dados da tabela
            $data = DB::table('input_files')->get();
    
            // Verificar se há dados
            if ($data->isEmpty()) {
                throw new \Exception("Nenhum dado encontrado na tabela.");
            }
    
            // Preparar conteúdo do arquivo TXT
            $txtContent = '';
            foreach ($data as $row) {
                $data_contato = str_replace('-', '', substr($row->updated_at, 0, 10));
                $hora_contato = str_replace(':', '', substr($row->updated_at, 11, 8));

                $txtContent .= "{$row->created_at};{$row->contrato_cliente};{$row->telefone_cliente};{$row->status};{$data_contato};{$hora_contato}\n";
    
                // Salvar os dados no banco de dados
                OutputFile::create([
                    'data_movimento' => $data_contato,
                    'contrato_cliente' => $row->contrato_cliente,
                    'nome_cliente' => $row->nome_cliente, 
                    'telefone_cliente' => $row->telefone_cliente,
                    'ocorrencia' => $row->status, // Adicione o campo correto se existir
                    'data_contato' => $data_contato,
                    'hora_contato' => $hora_contato,
                ]);
            }
    
            // Gerar nome do arquivo com timestamp
            $fileName = 'dados_' . time() . '.txt';
    
            // Salvar arquivo TXT localmente
            $localFilePath = storage_path("app/{$fileName}");
            file_put_contents($localFilePath, $txtContent);
    
            // Salvar arquivo TXT no storage
            Storage::put($fileName, $txtContent);
    
            // Fazer upload do arquivo para o FTP externo
            $ftpHost = '10.100.0.92';
            $ftpPort = 5021;
            $ftpUsername = 'cemigftp';
            $ftpPassword = 'tel@2020';
    
            $ftpConnection = ftp_connect($ftpHost, $ftpPort);
            ftp_login($ftpConnection, $ftpUsername, $ftpPassword);
            ftp_pasv($ftpConnection, true);
    
            // Abrir o arquivo local para leitura
            $localFileHandle = fopen($localFilePath, 'r');
    
            // Verificar se o arquivo local foi aberto com sucesso
            if ($localFileHandle) {
                // Enviar o conteúdo do arquivo para o servidor FTP
                if (ftp_fput($ftpConnection, "/outputfile/{$fileName}", $localFileHandle, FTP_ASCII)) {
                    echo "Arquivo enviado com sucesso para o servidor FTP.";
                } else {
                    echo "Falha ao enviar o arquivo para o servidor FTP.";
                }
                
                // Fechar o arquivo local
                fclose($localFileHandle);
            } else {
                echo "Falha ao abrir o arquivo local.";
            }
    
            // Fechar a conexão FTP
            ftp_close($ftpConnection);
    
            // Remover arquivos antigos localmente (mais velhos que uma semana)
            $oldLocalFiles = Storage::files();
            foreach ($oldLocalFiles as $file) {
                $fileInfo = Storage::lastModified($file);
                if ($fileInfo < strtotime('-1 week')) {
                    Storage::delete($file);
                }
            }
    
            // Remover arquivos antigos no FTP (mais velhos que uma semana)
            $ftpConnection = ftp_connect($ftpHost, $ftpPort);
            ftp_login($ftpConnection, $ftpUsername, $ftpPassword);
            ftp_pasv($ftpConnection, true);
            $oldFtpFiles = ftp_nlist($ftpConnection, "/outputfile/");
            foreach ($oldFtpFiles as $file) {
                $fileInfo = ftp_mdtm($ftpConnection, $file);
                if ($fileInfo < strtotime('-1 week')) {
                    ftp_delete($ftpConnection, $file);
                }
            }
            ftp_close($ftpConnection);
    
            // Retornar uma resposta de sucesso
            return response()->json(['message' => 'Arquivo TXT gerado, enviado para o servidor FTP e armazenado no banco de dados com sucesso.']);
    
        } catch (\Exception $e) {
            // Em caso de erro, enviar notificação por e-mail ou Telegram
            // Mail::to('seu-email@example.com')->send(new ErrorNotification($e->getMessage()));
            // Ou enviar uma mensagem para o Telegram
            // Telegram::sendMessage(['chat_id' => 'YOUR_CHAT_ID', 'text' => $e->getMessage()]);
    
            // Retornar uma resposta de erro
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}