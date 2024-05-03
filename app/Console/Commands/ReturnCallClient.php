<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CustomLog;

class ReturnCallClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:return-call-client';

    protected $description = 'Call API return_call method';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Chama a rota da API
        $response = Http::get(url('/api/return_call'));

        // Registra o log
        $log = new CustomLog();
        $log->content = $response->body();
        $log->operation = 'custom';

        if ($response->successful()) {
            $log->save();
            $this->info('API return_call method called successfully. Dados migrados com sucesso.');
        } else {
            $log->content = 'Erro ao chamar a API return_call: ' . $response->body();
            $log->save();
            $this->error('Failed to call API return_call method. ' . $response->status() . ': ' . $response->body());
        }
    }
}