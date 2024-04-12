<?php

namespace Database\Seeders;

use App\Models\DialStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DialStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!DialStatus::where('cod_dial_status', '00')->first()) {
            DialStatus::create([
                'cod_dial_status' => '00',
                'description' => 'Recebeu a mensagem voz completa',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '01')->first()) {
            DialStatus::create([
                'cod_dial_status' => '01',
                'description' => 'Recebeu a mensagem voz incompleta',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '02')->first()) {
            DialStatus::create([
                'cod_dial_status' => '02',
                'description' => 'Indisponível',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '03')->first()) {
            DialStatus::create([
                'cod_dial_status' => '03',
                'description' => 'Caixa postal',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '04')->first()) {
            DialStatus::create([
                'cod_dial_status' => '04',
                'description' => 'Invalido',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '05')->first()) {
            DialStatus::create([
                'cod_dial_status' => '05',
                'description' => 'Cancelado',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '06')->first()) {
            DialStatus::create([
                'cod_dial_status' => '06',
                'description' => 'Falha',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '07')->first()) {
            DialStatus::create([
                'cod_dial_status' => '07',
                'description' => 'Blacklist',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '08')->first()) {
            DialStatus::create([
                'cod_dial_status' => '08',
                'description' => 'Ocupado',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '09')->first()) {
            DialStatus::create([
                'cod_dial_status' => '09',
                'description' => 'Não Executado',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '10')->first()) {
            DialStatus::create([
                'cod_dial_status' => '10',
                'description' => 'Número errado',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '11')->first()) {
            DialStatus::create([
                'cod_dial_status' => '11',
                'description' => 'Falha na Operadora',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '12')->first()) {
            DialStatus::create([
                'cod_dial_status' => '12',
                'description' => 'Recado Ura',

            ]);
        }

        if (!DialStatus::where('cod_dial_status', '13')->first()) {
            DialStatus::create([
                'cod_dial_status' => '13',
                'description' => 'Mensagem Operadora',

            ]);
        }
    }
}
