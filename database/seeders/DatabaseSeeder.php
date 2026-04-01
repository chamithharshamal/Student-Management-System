<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
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
        User::updateOrCreate(
            ['email' => 'admin@school.test'],
            [
                'name' => 'Admin User',
                'password' => 'password',
            ]
        );

        $students = [
            ['reg_no' => 'STU-1001', 'name' => 'Ava Smith', 'address' => 'Colombo', 'dob' => '2008-02-14', 'age' => 18],
            ['reg_no' => 'STU-1002', 'name' => 'Noah Perera', 'address' => 'Kandy', 'dob' => '2007-11-03', 'age' => 18],
            ['reg_no' => 'STU-1003', 'name' => 'Mia Fernando', 'address' => 'Galle', 'dob' => '2008-06-21', 'age' => 17],
            ['reg_no' => 'STU-1004', 'name' => 'Liam Silva', 'address' => 'Jaffna', 'dob' => '2007-09-09', 'age' => 18],
            ['reg_no' => 'STU-1005', 'name' => 'Sofia James', 'address' => 'Negombo', 'dob' => '2008-12-17', 'age' => 17],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(
                ['reg_no' => $student['reg_no']],
                $student
            );
        }
    }
}
