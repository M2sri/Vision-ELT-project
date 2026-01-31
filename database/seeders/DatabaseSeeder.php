<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\TestResult;
use Illuminate\Database\Seeder;
use Database\Seeders\Zone1PlacementTestSeeder;


class DatabaseSeeder extends Seeder
{
    public function run()
{
    // =========================
    // SEED TESTS FIRST
    // =========================
    $this->call([
        PlacementTestSeeder::class,     // Adult
        Zone1PlacementTestSeeder::class,
         AdminSeeder::class, // Kids Zone 1
    ]);

 

    // =========================
    // SAMPLE STUDENTS
    // =========================
    $students = Student::factory(20)->create();

    // =========================
    // TEST RESULTS
    // =========================
    foreach ($students as $student) {
        TestResult::factory(rand(1, 3))->create([
            'student_id' => $student->id,
        ]);
    }
}

}
