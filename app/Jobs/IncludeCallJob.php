<?php

namespace App\Jobs;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Telephone;
use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncludeCallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //public $queue = 'insertcall'; // Definindo o nome da fila
    protected $contact;

    /**
     * Create a new job instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $id_campaign = 2;
        $pessoa_codigo = $this->contact->pessoa_codigo;
        $pessoa_nome = $this->contact->pessoa_nome;
        $pessoa_cpf = $this->contact->pessoa_cpf;
        // Obter o número de telefone do primeiro telefone do contato
        $phone = null;
        if ($this->contact->telephones->isNotEmpty()) {
        $telefone = $this->contact->telephones->first();
        $phone = $telefone->ddd . $telefone->telefone;
}
        try {
            // Realiza a inserção no banco de dados externo
            \DB::connection('mysql_external')->table('call_center.calls')->insert([
                'id_campaign' => $id_campaign,
                'pessoa_codigo' => $pessoa_codigo,
                'pessoa_nome' => $pessoa_nome,
                'pessoa_cpf' => $pessoa_cpf,
                'phone' => $phone
            ]);

            // Atualiza o status da campanha
            \DB::connection('mysql_external')->table('campaign')->where('id', $id_campaign)->update(['estatus' => 'A']);

            // Grava um log de sucesso
            \Log::info('Dados inseridos com sucesso');
        } catch (\Exception $e) {
            // Em caso de erro, lança uma exceção
            throw new \Exception('Erro ao inserir dados: ' . $e->getMessage());
        }
    }
}