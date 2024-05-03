<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IvrUser;

class IvrUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        
            if (!IvrUser::where('user_nome', 'CEMIG')->first()) {
                IvrUser::create([
                    'user_nome' => 'CEMIG',
                    'user_key' => '',
                    'token' => '',
                    'user_validade' => '',
                    'token_validade' => '',
                    'acd' => '3',
                    'retorno_url' => '',
                    'retorno_user' => '',
                    'retorno_key' => '',
                    'retorno_token' => '',
                
                ]);
            }
        
            if (!IvrUser::where('user_nome', 'ENEL')->first()) {
                IvrUser::create([
                    'user_nome' => 'ENEL',
                    'user_key' => '',
                    'token' => '',
                    'user_validade' => '',
                    'token_validade' => '',
                    'acd' => '2',
                    'retorno_url' => '',
                    'retorno_user' => '',
                    'retorno_key' => '',
                    'retorno_token' => '',
    
                ]);
            }
            if (!IvrUser::where('user_nome', 'TELECOM')->first()) {
                IvrUser::create([
                    'user_nome' => 'TELECOM',
                    'user_key' => '',
                    'token' => '',
                    'user_validade' => '',
                    'token_validade' => '',
                    'acd' => '1',
                    'retorno_url' => '',
                    'retorno_user' => '',
                    'retorno_key' => '',
                    'retorno_token' => '',
    
                ]);
            
            }
    }
}
