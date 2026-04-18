<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Admin ────────────────────────────────────────────────────────────
        Admin::updateOrCreate(
            ['username' => 'admin'],
            ['password' => 'test']
        );

        // ── Students ─────────────────────────────────────────────────────────
        $students = [
            ['reg_no' => 'STU-1001', 'name' => 'Nadeesha Perera',       'address' => 'Colombo',  'dob' => '2008-02-14', 'age' => 18],
            ['reg_no' => 'STU-1002', 'name' => 'Kavindu Jayasekara',    'address' => 'Kandy',    'dob' => '2007-11-03', 'age' => 18],
            ['reg_no' => 'STU-1003', 'name' => 'Sachini Fernando',      'address' => 'Galle',    'dob' => '2008-06-21', 'age' => 17],
            ['reg_no' => 'STU-1004', 'name' => 'Hashan Silva',          'address' => 'Jaffna',   'dob' => '2007-09-09', 'age' => 18],
            ['reg_no' => 'STU-1005', 'name' => 'Thisarani Karunarathna','address' => 'Negombo',  'dob' => '2008-12-17', 'age' => 17],
            ['reg_no' => 'STU-1006', 'name' => 'Chamith Weerasinghe',   'address' => 'Homagama', 'dob' => '1999-05-22', 'age' => 26],
        ];

        foreach ($students as $data) {
            Student::updateOrCreate(['reg_no' => $data['reg_no']], $data);
        }

        // ── Teachers ─────────────────────────────────────────────────────────
        $teacherData = [
            [
                'name'           => 'Dr. Priya Mendis',
                'email'          => 'priya.mendis@school.lk',
                'phone'          => '0771234567',
                'qualification'  => 'PhD in Mathematics',
                'specialization' => 'Mathematics',
            ],
            [
                'name'           => 'Mr. Roshan Perera',
                'email'          => 'roshan.perera@school.lk',
                'phone'          => '0769876543',
                'qualification'  => 'BSc in Computer Science',
                'specialization' => 'Information Technology',
            ],
            [
                'name'           => 'Ms. Dilini Wickramasinghe',
                'email'          => 'dilini.w@school.lk',
                'phone'          => '0712345678',
                'qualification'  => 'MA in English Literature',
                'specialization' => 'English Language',
            ],
            [
                'name'           => 'Mr. Saman Dissanayake',
                'email'          => 'saman.d@school.lk',
                'phone'          => '0754321987',
                'qualification'  => 'BSc in Physics',
                'specialization' => 'Physics',
            ],
        ];

        $teachers = [];
        foreach ($teacherData as $data) {
            $teachers[$data['specialization']] = Teacher::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        // ── Courses ──────────────────────────────────────────────────────────
        $courseData = [
            [
                'code'        => 'MTH-101',
                'name'        => 'Mathematics I',
                'description' => 'Foundations of calculus, algebra and trigonometry.',
                'credits'     => 3,
                'teacher_id'  => $teachers['Mathematics']->id,
            ],
            [
                'code'        => 'MTH-201',
                'name'        => 'Mathematics II',
                'description' => 'Advanced calculus and linear algebra.',
                'credits'     => 3,
                'teacher_id'  => $teachers['Mathematics']->id,
            ],
            [
                'code'        => 'ICT-101',
                'name'        => 'Introduction to ICT',
                'description' => 'Basic computer skills, networking and software fundamentals.',
                'credits'     => 2,
                'teacher_id'  => $teachers['Information Technology']->id,
            ],
            [
                'code'        => 'ICT-201',
                'name'        => 'Web Development',
                'description' => 'HTML, CSS, JavaScript and PHP basics.',
                'credits'     => 4,
                'teacher_id'  => $teachers['Information Technology']->id,
            ],
            [
                'code'        => 'ENG-101',
                'name'        => 'English Language',
                'description' => 'Grammar, comprehension and written communication.',
                'credits'     => 2,
                'teacher_id'  => $teachers['English Language']->id,
            ],
            [
                'code'        => 'PHY-101',
                'name'        => 'Physics I',
                'description' => 'Mechanics, waves, and thermodynamics.',
                'credits'     => 3,
                'teacher_id'  => $teachers['Physics']->id,
            ],
        ];

        $courses = [];
        foreach ($courseData as $data) {
            $courses[$data['code']] = Course::updateOrCreate(
                ['code' => $data['code']],
                $data
            );
        }

        // ── Enrollments ──────────────────────────────────────────────────────
        $allStudents = Student::all()->keyBy('reg_no');

        $enrollmentData = [
            // Nadeesha – active in MTH, ICT, ENG
            ['student' => 'STU-1001', 'course' => 'MTH-101', 'enrolled_at' => '2024-01-10', 'status' => 'active',    'grade' => null],
            ['student' => 'STU-1001', 'course' => 'ICT-101', 'enrolled_at' => '2024-01-10', 'status' => 'active',    'grade' => null],
            ['student' => 'STU-1001', 'course' => 'ENG-101', 'enrolled_at' => '2024-01-10', 'status' => 'completed', 'grade' => 'A'],

            // Kavindu – completed MTH-101, active in ICT-201, PHY-101
            ['student' => 'STU-1002', 'course' => 'MTH-101', 'enrolled_at' => '2024-01-15', 'status' => 'completed', 'grade' => 'B+'],
            ['student' => 'STU-1002', 'course' => 'ICT-201', 'enrolled_at' => '2024-01-15', 'status' => 'active',    'grade' => null],
            ['student' => 'STU-1002', 'course' => 'PHY-101', 'enrolled_at' => '2024-01-15', 'status' => 'active',    'grade' => null],

            // Sachini – ENG completed with A+, dropped PHY
            ['student' => 'STU-1003', 'course' => 'ENG-101', 'enrolled_at' => '2024-02-01', 'status' => 'completed', 'grade' => 'A+'],
            ['student' => 'STU-1003', 'course' => 'MTH-101', 'enrolled_at' => '2024-02-01', 'status' => 'active',    'grade' => null],
            ['student' => 'STU-1003', 'course' => 'PHY-101', 'enrolled_at' => '2024-02-01', 'status' => 'dropped',   'grade' => null],

            // Hashan – active in ICT & MTH-201
            ['student' => 'STU-1004', 'course' => 'ICT-101', 'enrolled_at' => '2024-02-10', 'status' => 'active',    'grade' => null],
            ['student' => 'STU-1004', 'course' => 'MTH-201', 'enrolled_at' => '2024-02-10', 'status' => 'active',    'grade' => null],

            // Thisarani – completed ENG, dropped ICT
            ['student' => 'STU-1005', 'course' => 'ENG-101', 'enrolled_at' => '2024-03-05', 'status' => 'completed', 'grade' => 'B'],
            ['student' => 'STU-1005', 'course' => 'ICT-201', 'enrolled_at' => '2024-03-05', 'status' => 'dropped',   'grade' => null],

            // Chamith – active across several courses
            ['student' => 'STU-1006', 'course' => 'ICT-101', 'enrolled_at' => '2024-03-10', 'status' => 'completed', 'grade' => 'A'],
            ['student' => 'STU-1006', 'course' => 'ICT-201', 'enrolled_at' => '2024-03-10', 'status' => 'active',    'grade' => null],
            ['student' => 'STU-1006', 'course' => 'MTH-101', 'enrolled_at' => '2024-03-10', 'status' => 'active',    'grade' => null],
            ['student' => 'STU-1006', 'course' => 'PHY-101', 'enrolled_at' => '2024-03-10', 'status' => 'active',    'grade' => null],
        ];

        foreach ($enrollmentData as $row) {
            Enrollment::updateOrCreate(
                [
                    'student_id' => $allStudents[$row['student']]->id,
                    'course_id'  => $courses[$row['course']]->id,
                ],
                [
                    'enrolled_at' => $row['enrolled_at'],
                    'status'      => $row['status'],
                    'grade'       => $row['grade'],
                ]
            );
        }
    }
}
