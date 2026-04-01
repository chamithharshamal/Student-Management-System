<?php

namespace App\Http\Controllers;

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
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withErrors([
                'email' => 'The provided credentials are incorrect.',
            ])
            ->onlyInput('email');
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
}
