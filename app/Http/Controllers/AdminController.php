<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\SimpleExcel\SimpleExcelReader;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withErrors([
                'username' => 'The provided credentials are incorrect.',
            ])
            ->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $studentCount = Student::count();
        $thisMonthCount = Student::whereMonth('created_at', Carbon::now()->month)->count();
        $courseCount = \App\Models\Course::count();
        $teacherCount = \App\Models\Teacher::count();

        $stats = [
            ['label' => 'Students', 'value' => $studentCount, 'detail' => 'Active enrollments', 'accent' => 'blue'],
            ['label' => 'New This Month', 'value' => $thisMonthCount, 'detail' => 'Recent registrations', 'accent' => 'emerald'],
            ['label' => 'Courses', 'value' => $courseCount, 'detail' => 'Published modules', 'accent' => 'violet'],
            ['label' => 'Teachers', 'value' => $teacherCount, 'detail' => 'Assigned staff', 'accent' => 'amber'],
        ];

        $recentStudents = Student::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentStudents'));
    }

    public function students(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            $direction = $request->sort === 'desc' ? 'desc' : 'asc';
            $query->orderBy('reg_no', $direction);
        } else {
            $query->orderBy('reg_no', 'asc');
        }

        $students = $query->get();

        $lastStudent = Student::orderBy('id', 'desc')->first();
        $nextRegNo = 'STU-1001';
        
        if ($lastStudent && preg_match('/^([A-Za-z\-]+)(\d+)$/', $lastStudent->reg_no, $matches)) {
            $prefix = $matches[1];
            $number = (int)$matches[2];
            $nextRegNo = $prefix . str_pad($number + 1, strlen($matches[2]), '0', STR_PAD_LEFT);
        } elseif ($lastStudent && is_numeric($lastStudent->reg_no)) {
            $nextRegNo = $lastStudent->reg_no + 1;
        }

        return view('admin.students', compact('students', 'nextRegNo'));
    }

    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'reg_no' => ['required', 'string', 'max:255', 'unique:students,reg_no'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
        ]);

        $validated['age'] = Carbon::parse($validated['dob'])->age;

        Student::create($validated);

        return redirect()
            ->route('admin.students')
            ->with('status', 'Student added successfully.');
    }

    public function updateStudent(Request $request, Student $student)
    {
        $validated = $request->validate([
            'reg_no' => ['required', 'string', 'max:255', 'unique:students,reg_no,' . $student->id],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:today'],
        ]);

        $validated['age'] = Carbon::parse($validated['dob'])->age;

        $student->update($validated);

        return redirect()
            ->route('admin.students')
            ->with('status', 'Student updated successfully.');
    }

    public function deleteStudent(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('admin.students')
            ->with('status', 'Student deleted successfully.');
    }

    public function exportCsv(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            $direction = $request->sort === 'desc' ? 'desc' : 'asc';
            $query->orderBy('reg_no', $direction);
        } else {
            $query->orderBy('reg_no', 'asc');
        }

        $students = $query->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=students.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Reg No', 'Name', 'Address', 'DOB', 'Age'];

        $callback = function() use($students, $columns) {
            $file = fopen('php://output', 'w');
            // Adding BOM for UTF-8 Excel support
            fputs($file, $bom =(chr(0xEF) . chr(0xBB) . chr(0xBF)));
            fputcsv($file, $columns);

            foreach ($students as $student) {
                $row['Reg No']  = $student->reg_no;
                $row['Name']    = $student->name;
                $row['Address'] = $student->address;
                $row['DOB']     = Carbon::parse($student->dob)->format('Y-m-d');
                $row['Age']     = $student->age;

                fputcsv($file, array($row['Reg No'], $row['Name'], $row['Address'], $row['DOB'], $row['Age']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            $direction = $request->sort === 'desc' ? 'desc' : 'asc';
            $query->orderBy('reg_no', $direction);
        } else {
            $query->orderBy('reg_no', 'asc');
        }

        $students = $query->get();

        $pdf = Pdf::loadView('admin.students_pdf', compact('students'));
        
        return $pdf->download('students.pdf');
    }

    public function importStudents(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        $file = $request->file('file');
        $filePath = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();

        try {
            $reader = SimpleExcelReader::create($filePath, $extension);
            
            $rowsProcessed = 0;
            $rowsSkipped = 0;

            $reader->getRows()->each(function (array $row) use (&$rowsProcessed, &$rowsSkipped) {
                // Map columns - provide some flexibility for header names
                $regNo = $row['reg_no'] ?? $row['Reg No'] ?? $row['Registration No'] ?? null;
                $name = $row['name'] ?? $row['Name'] ?? $row['Student Name'] ?? null;
                $address = $row['address'] ?? $row['Address'] ?? null;
                $dob = $row['dob'] ?? $row['DOB'] ?? $row['Date of Birth'] ?? null;

                if ($regNo && $name) {
                    // Check if student already exists
                    if (Student::where('reg_no', $regNo)->exists()) {
                        $rowsSkipped++;
                        return;
                    }

                    $age = null;
                    if ($dob) {
                        try {
                            $dobDate = Carbon::parse($dob);
                            $age = $dobDate->age;
                            $dob = $dobDate->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Invalid date format, skip or handle
                        }
                    }

                    Student::create([
                        'reg_no' => $regNo,
                        'name' => $name,
                        'address' => $address ?? '',
                        'dob' => $dob,
                        'age' => $age,
                    ]);

                    $rowsProcessed++;
                } else {
                    $rowsSkipped++;
                }
            });

            $statusMessage = "Import completed! {$rowsProcessed} students added.";
            if ($rowsSkipped > 0) {
                $statusMessage .= " {$rowsSkipped} rows were skipped (duplicates or missing data).";
            }

            return redirect()
                ->route('admin.students')
                ->with('status', $statusMessage);

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.students')
                ->withErrors(['file' => 'Error processing the file: ' . $e->getMessage()]);
        }
    }
}
