<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'michelpenha@cercred.com.br')->first()) {
            $superAdmin = User::create([
                'name' => 'Michel',
                'cpf_cnpj' => '',
                'domain' => '',
                'email' => 'michelpenha@cercred.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir papel para o usuário
            $superAdmin->assignRole('Super Admin');
        }

        if (!User::where('email', 'telecom@cercred.com.br')->first()) {
            $admin = User::create([
                'name' => 'Telecom',
                'cpf_cnpj' => '',
                'domain' => '',
                'email' => 'telecom@cercred.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir papel para o usuário
            $admin->assignRole('Super Admin');
        }

        if (!User::where('email', 'bruno@cercred.com.br')->first()) {
            $teacher = User::create([
                'name' => 'Bruno',
                'cpf_cnpj' => '',
                'domain' => '',
                'email' => 'bruno@cercred.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir papel para o usuário
            $admin->assignRole('Admin');
        }

        if (!User::where('email', 'isabela@cercred.com.br')->first()) {
            $tutor = User::create([
                'name' => 'Isabela',
                'cpf_cnpj' => '',
                'domain' => '',
                'email' => 'isabela@cercred.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir papel para o usuário
            $admin->assignRole('Admin');
        }

        if (!User::where('email', 'lucas@cercred.com.br')->first()) {
            $student = User::create([
                'name' => 'Lucas',
                'cpf_cnpj' => '',
                'domain' => '',
                'email' => 'lucas@cercred.com.br',
                'password' => Hash::make('123456a', ['rounds' => 10])
            ]);

            // Atribuir papel para o usuário
            $admin->assignRole('Admin');
        }
    }
}
