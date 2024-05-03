<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CustomLog;


class IncludeCallApp extends Command
{
    protected $signature = 'app:include-call-app';

    protected $description = 'Comando que pega os dados de discagem e insere no banco local da app';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Chama a rota da API
        $response = Http::get(url('/api/return_store'));

        // Registra o log
        $log = new CustomLog();
        $log->content = $response->body();
        $log->operation = 'custom';

        if ($response->successful()) {
            $log->save();
            $this->info('Dados salvos no Banco local.');
        } else {
            $log->content = 'Erro ao inserir dados: ' . $response->body();
            $log->save();
            $this->error('Falha para chamada Metodo.' . $response->status() . ': ' . $response->body());
        }
    }
}