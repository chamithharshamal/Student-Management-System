<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $stats = [
            ['label' => 'Students', 'value' => $studentCount, 'detail' => 'Active enrollments', 'accent' => 'blue'],
            ['label' => 'Courses', 'value' => 12, 'detail' => 'Published modules', 'accent' => 'violet'],
            ['label' => 'Teachers', 'value' => 8, 'detail' => 'Assigned staff', 'accent' => 'emerald'],
            ['label' => 'Grades', 'value' => 24, 'detail' => 'Recorded results', 'accent' => 'amber'],
        ];

        $recentStudents = Student::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentStudents'));
    }

    public function students()
    {
        $students = Student::orderBy('id')->get();

        return view('admin.students', compact('students'));
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
}
