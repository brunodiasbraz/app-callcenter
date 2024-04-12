<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomLog;
use Carbon\Carbon;

class CleanLogs extends Command
{
    protected $signature = 'logs:clean';

    protected $description = 'Limpar registros de log mais antigos';

    public function handle()
    {
        // Define a data limite para manter os registros (30 dias atrás)
        // $thresholdDate = Carbon::now()->subDays(30);

        // Define a data limite para manter os registros (24 horas atrás)
        $thresholdDate = Carbon::now()->subHours(24);

        // Define a data limite para manter os registros (30 minutos atrás)
        //$thresholdDate = Carbon::now()->subMinutes(30);

        // Seleciona e exibe os registros que serão excluídos
        $logsToDelete = CustomLog::where('created_at', '<', $thresholdDate)->get();
        $this->info('Registros de log para exclusão: ' . $logsToDelete->count());

        // Exclui os registros mais antigos
        $deleted = CustomLog::where('created_at', '<', $thresholdDate)->delete();

        if ($deleted > 0) {
            $this->info('Registros de log antigos foram excluídos.');
        } else {
            $this->info('Nenhum registro de log antigo encontrado para exclusão.');
        }
    }
}
