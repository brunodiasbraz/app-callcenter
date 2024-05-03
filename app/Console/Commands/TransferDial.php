<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferDial extends Command
{
    protected $signature = 'transfer:dial';
    protected $description = 'Transfer data from local MySQL to external MySQL for dial';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Conectar ao banco de dados MySQL local
        try {
            $localMysqlConnection = DB::connection('mysql');
        } catch (\Exception $e) {
            $this->error('Erro ao conectar ao banco de dados local MySQL: ' . $e->getMessage());
            return;
        }

        // Conectar ao banco de dados MySQL externo
        try {
            $externalMysqlConnection = DB::connection('mysql_external');
        } catch (\Exception $e) {
            $this->error('Erro ao conectar ao banco de dados externo MySQL: ' . $e->getMessage());
            return;
        }

        // Obter os dados da tabela Telephone do banco de dados local
        try {
            $data = $localMysqlConnection->table('Telephones')->select('ddd', 'telefone')->get();
        } catch (\Exception $e) {
            $this->error('Erro ao obter dados da tabela Telephone: ' . $e->getMessage());
            return;
        }

        // Iniciar a transação no banco de dados MySQL externo
        try {
            $externalMysqlConnection->beginTransaction();
        } catch (\Exception $e) {
            $this->error('Erro ao iniciar transação no banco de dados externo: ' . $e->getMessage());
            return;
        }

        try {
            foreach ($data as $row) {
                // Concatenar DDD e telefone
                $phone = $row->ddd . $row->telefone;

                // Inserir os dados na tabela calls do banco de dados externo
                $externalMysqlConnection->table('call_center.calls')->insert([
                    'id_campaign' => 2, // Definir o valor do campo id_campaign
                    'phone' => $phone
                ]);
            }

            // Commit se tudo correr bem
            $externalMysqlConnection->commit();

            $this->info('Dados transferidos com sucesso!');
        } catch (\Exception $e) {
            // Rollback em caso de erro
            $externalMysqlConnection->rollback();
            $this->error('Erro ao transferir dados: ' . $e->getMessage());
        }
    }
}
