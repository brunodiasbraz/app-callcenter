<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Course::where('name', 'Curso de Laravel - T1')->first()) {
            Course::create([
                'name' => 'Curso de Laravel - T1',
                'price' => '147.52',
                'api_token' => '',
                'api_validate' => '',

            ]);
        }

        if (!Course::where('name', 'Curso de Laravel - T2')->first()) {
            Course::create([
                'name' => 'Curso de Laravel - T2',
                'price' => '197.25',
                'api_token' => '',
                'api_validate' => '',
            ]);
        }
    }
}
