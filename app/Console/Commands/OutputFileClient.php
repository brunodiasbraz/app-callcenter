<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CustomLog;

class OutputFileClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:output-file';

    protected $description = 'Call API output-file method';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Chama a rota da API
        $response = Http::get(url('/api/hml/output-file'));

        // Registra o log
        $log = new CustomLog();
        $log->content = $response->body();
        $log->operation = 'custom';

        if ($response->successful()) {
            $log->save();
            $this->info('API output-file method called successfully. Dados migrados com sucesso.');
        } else {
            $log->content = 'Erro ao chamar a API output-file: ' . $response->body();
            $log->save();
            $this->error('Failed to call API output-file method. ' . $response->status() . ': ' . $response->body());
        }
    }
}