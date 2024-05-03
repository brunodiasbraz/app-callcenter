<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferDialPgsqltoMysql extends Command
{
    protected $signature = 'transfer:dialpgsqltomysql';
    protected $description = 'Transfer data from local PostgreSQL to external MySQL for dial';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Conectar ao banco de dados PostgreSQL local
        try {
            $localPgsqlConnection = DB::connection('pgsql');
        } catch (\Exception $e) {
            $this->error('Erro ao conectar ao banco de dados local PostgreSQL: ' . $e->getMessage());
            return;
        }

        // Conectar ao banco de dados MySQL externo
        try {
            $externalMysqlConnection = DB::connection('mysql_external');
        } catch (\Exception $e) {
            $this->error('Erro ao conectar ao banco de dados externo MySQL: ' . $e->getMessage());
            return;
        }

        // Obter os dados da tabela telephone do banco de dados PostgreSQL local
        try {
            $data = $localPgsqlConnection->table('telephones')->select('ddd', 'telefone')->get();
        } catch (\Exception $e) {
            $this->error('Erro ao obter dados da tabela telephone: ' . $e->getMessage());
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

                // Verificar se o número já existe no MySQL externo
                //$existingRecord = $externalMysqlConnection->table('call_center.calls')->where('phone', $phone)->first();

                // Se não existir, inserir os dados na tabela calls do banco de dados externo
                //if (!$existingRecord) {
                    $externalMysqlConnection->table('call_center.calls')->insert([
                        'id_campaign' => 2, // Definir o valor do campo id_campaign
                        'phone' => $phone
                    ]);
                //}
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
