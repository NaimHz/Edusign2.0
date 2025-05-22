<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Student;
use App\Models\Session;
use App\Models\Attendance;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Créer un cours
        $course = Course::create([
            'name' => 'Développement Web',
            'code' => 'WEB101',
            'qr_code' => uniqid('course_'),
            'description' => 'Cours de développement web avec Laravel et React'
        ]);

        // Créer quelques étudiants
        $students = [
            ['first_name' => 'Jean', 'last_name' => 'Dupont', 'email' => 'jean.dupont@example.com', 'student_id' => 'S1001'],
            ['first_name' => 'Marie', 'last_name' => 'Martin', 'email' => 'marie.martin@example.com', 'student_id' => 'S1002'],
            ['first_name' => 'Pierre', 'last_name' => 'Durand', 'email' => 'pierre.durand@example.com', 'student_id' => 'S1003'],
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }

        // Créer une séance
        $session = Session::create([
            'course_id' => $course->id,
            'name' => 'Introduction à Laravel',
            'start_time' => Carbon::now()->subHours(1),
            'end_time' => Carbon::now()->addHours(2),
            'qr_code' => uniqid('session_')
        ]);

        // Créer quelques présences
        $students = Student::all();
        foreach ($students as $index => $student) {
            if ($index < 2) { // Les deux premiers étudiants sont présents
                Attendance::create([
                    'student_id' => $student->id,
                    'session_id' => $session->id,
                    'status' => 'present',
                    'check_in' => Carbon::now()->subMinutes(30)
                ]);
            } else { // Le dernier étudiant est absent
                Attendance::create([
                    'student_id' => $student->id,
                    'session_id' => $session->id,
                    'status' => 'absent'
                ]);
            }
        }
    }
}
