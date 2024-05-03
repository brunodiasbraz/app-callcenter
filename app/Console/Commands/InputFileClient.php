<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CustomLog;

class InputFileClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:input-file {id_campaign}';

    protected $description = 'Call API input-file method';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $id_campaign = $this->argument('id_campaign');
        // Chama a rota da API
        $response = Http::get(url('/api/hml/input-file/' . $id_campaign));

        // Registra o log
        $log = new CustomLog();
        $log->content = $response->body();
        $log->operation = 'custom';

        if ($response->successful()) {
            $log->save();
            $this->info('API input-file method called successfully. Dados migrados com sucesso.');
        } else {
            $log->content = 'Erro ao chamar a API input-file: ' . $response->body();
            $log->save();
            $this->error('Failed to call API input-file method. ' . $response->status() . ': ' . $response->body());
        }
    }
}