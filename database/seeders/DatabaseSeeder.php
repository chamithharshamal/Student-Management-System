<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => 'test',
            ]
        );

        $students = [
            ['reg_no' => 'STU-1001', 'name' => 'Nadeesha Perera', 'address' => 'Colombo', 'dob' => '2008-02-14', 'age' => 18],
            ['reg_no' => 'STU-1002', 'name' => 'Kavindu Jayasekara', 'address' => 'Kandy', 'dob' => '2007-11-03', 'age' => 18],
            ['reg_no' => 'STU-1003', 'name' => 'Sachini Fernando', 'address' => 'Galle', 'dob' => '2008-06-21', 'age' => 17],
            ['reg_no' => 'STU-1004', 'name' => 'Hashan Silva', 'address' => 'Jaffna', 'dob' => '2007-09-09', 'age' => 18],
            ['reg_no' => 'STU-1005', 'name' => 'Thisarani Karunarathna', 'address' => 'Negombo', 'dob' => '2008-12-17', 'age' => 17],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(
                ['reg_no' => $student['reg_no']],
                $student
            );
        }
    }
}
