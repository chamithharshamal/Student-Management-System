<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->latest()->get();
        $teachers = Teacher::all(); // To populate the dropdown
        return view('admin.courses', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:courses,code|max:50',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        Course::create($request->all());

        return redirect()->route('admin.courses')->with('status', 'Course added successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        $course->update($request->all());

        return redirect()->route('admin.courses')->with('status', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')->with('status', 'Course deleted successfully.');
    }
}
