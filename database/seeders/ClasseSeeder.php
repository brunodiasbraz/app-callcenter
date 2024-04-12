<?php

namespace Database\Seeders;

use App\Models\Classe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Classe::where('name', 'Aula 1')->first()){
            Classe::create([
                'name' => 'Aula 1',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla cursus sagittis justo ut volutpat. Nam rutrum eros velit, vel bibendum sapien pulvinar sit amet. Vestibulum a enim magna.',
                'order_classe' => 1,
                'course_id' => 1
            ]);
        }
        if(!Classe::where('name', 'Aula 2')->first()){
            Classe::create([
                'name' => 'Aula 2',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla cursus sagittis justo ut volutpat. Nam rutrum eros velit, vel bibendum sapien pulvinar sit amet. Vestibulum a enim magna.',
                'order_classe' => 2,
                'course_id' => 1
            ]);
        }
        if(!Classe::where('name', 'Aula 1 B')->first()){
            Classe::create([
                'name' => 'Aula 1 B',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla cursus sagittis justo ut volutpat. Nam rutrum eros velit, vel bibendum sapien pulvinar sit amet. Vestibulum a enim magna.',
                'order_classe' => 1,
                'course_id' => 2
            ]);
        }
    }
}
