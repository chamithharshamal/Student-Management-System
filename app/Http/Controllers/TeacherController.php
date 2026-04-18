<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::latest()->get();
        return view('admin.teachers', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'required|string|max:255',
        ]);

        Teacher::create($request->all());

        return redirect()->route('admin.teachers')->with('status', 'Teacher added successfully.');
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'specialization' => 'required|string|max:255',
        ]);

        $teacher->update($request->all());

        return redirect()->route('admin.teachers')->with('status', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers')->with('status', 'Teacher deleted successfully.');
    }
}
