<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Contact::where('campanha', 'Teste Telecom')->first()) {
            Contact::create([
                'campanha' => 'Teste Telecom',
                'pessoa_codigo' => 'teste-88888888',
                'pessoa_nome' => 'Cliente Teste',
                'pessoa_cpf' => '12345678911',
                'pessoa_telefone' => '',
                'data_agenda' => '2024-04-01 08:00:00',
                'informacoes_extras' => 'Sem informacao',
                'user_nome' => 'Telecom',
                'valor_divida' => '',
                'prioridade' => '',

            ]);
        }

        if (!Contact::where('campanha', 'Teste2 Telecom T2')->first()) {
            Contact::create([
                'campanha' => 'Teste2 Telecom T2',
                'pessoa_codigo' => 'teste-99999999',
                'pessoa_nome' => 'Cliente2 Teste2',
                'pessoa_cpf' => '12345678922',
                'pessoa_telefone' => '',
                'data_agenda' => '2024-04-01 09:00:00',
                'informacoes_extras' => 'Sem informacao2',
                'user_nome' => 'Telecom2',
                'valor_divida' => '',
                'prioridade' => '',
            ]);
        }
    }
}
