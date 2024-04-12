<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        if (!Role::where('name', 'Super Admin')->first()) {
            Role::create([
                'name' => 'Super Admin'
            ]);
        }

        if (!Role::where('name', 'Admin')->first()) {
            $admin = Role::create([
                'name' => 'Admin'
            ]);

            // Dar permissão para o papel
            $admin->givePermissionTo([
                'index-course',
                'show-course',
                'create-course',
                'edit-course',
                'destroy-course',

                'index-classe',
                'show-classe',
                'create-classe',
                'edit-classe',
                'destroy-classe',

                'index-user',
                'show-user',
                'create-user',
                'edit-user',
                'edit-user-password',
                'destroy-user',
            ]);
        }

        if (!Role::where('name', 'Professor')->first()) {
            $teacher = Role::create([
                'name' => 'Professor'
            ]);

            $teacher->givePermissionTo([
                'index-course',
                'show-course',
                'create-course',
                'edit-course',
                'destroy-course',

                'index-classe',
                'show-classe',
                'create-classe',
                'edit-classe',
                'destroy-classe',

                'index-user',
                'show-user',
            ]);
        }

        if (!Role::where('name', 'Tutor')->first()) {
            $tutor = Role::create([
                'name' => 'Tutor'
            ]);

            $tutor->givePermissionTo([
                'index-course',
                'show-course',
                'edit-course',

                'index-classe',
                'show-classe',
                'edit-classe',

                'index-user',
                'show-user',
            ]);
        }

        if (!Role::where('name', 'Aluno')->first()) {
            Role::create([
                'name' => 'Aluno'
            ]);
        }
    }
}
