<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('logs:clean')->daily(); // Executa a limpeza diariamente

        // Olha se tem registros na tabela input_files com status pendente para serem enviados para discagem no 88
        $schedule->command('app:dial-input-files')->everyTenSeconds(); 

        //$schedule->command('app:include-call-app')->everyFiveSeconds();
        //$schedule->command('app:return-call-client')->everyTenSeconds();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
