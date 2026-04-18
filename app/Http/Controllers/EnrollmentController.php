<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['student', 'course.teacher']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('reg_no', 'like', "%{$search}%"))
                ->orWhereHas('course', fn($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->latest()->paginate(15)->withQueryString();
        $students    = Student::orderBy('name')->get();
        $courses     = Course::with('teacher')->orderBy('name')->get();

        return view('admin.enrollments', compact('enrollments', 'students', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'  => 'required|exists:students,id',
            'course_id'   => 'required|exists:courses,id',
            'enrolled_at' => 'required|date',
            'status'      => 'required|in:active,completed,dropped',
        ]);

        // Check for duplicate
        $exists = Enrollment::where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'This student is already enrolled in that course.'])->withInput();
        }

        Enrollment::create($request->only('student_id', 'course_id', 'enrolled_at', 'status'));

        return back()->with('status', 'Student enrolled successfully.');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => 'required|in:active,completed,dropped',
            'grade'  => 'nullable|string|max:10',
        ]);

        $enrollment->update($request->only('status', 'grade'));

        return back()->with('status', 'Enrollment updated successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return back()->with('status', 'Enrollment removed successfully.');
    }

    // ── Export ────────────────────────────────────────────────────────────────

    private function buildFilteredQuery(Request $request)
    {
        $query = Enrollment::with(['student', 'course']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', fn($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('reg_no', 'like', "%{$search}%"))
                ->orWhereHas('course', fn($q) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->latest();
    }

    public function exportCsv(Request $request)
    {
        $enrollments = $this->buildFilteredQuery($request)->get();
        $filterLabel = $request->filled('status') ? '-' . $request->status : '';
        $filename    = 'enrollments' . $filterLabel . '.csv';

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($enrollments) {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Student Name', 'Reg No', 'Course Code', 'Course Name', 'Enrolled At', 'Status', 'Grade']);
            foreach ($enrollments as $e) {
                fputcsv($file, [
                    $e->student->name    ?? '',
                    $e->student->reg_no  ?? '',
                    $e->course->code     ?? '',
                    $e->course->name     ?? '',
                    $e->enrolled_at,
                    $e->status,
                    $e->grade            ?? '',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $enrollments = $this->buildFilteredQuery($request)->get();
        $filterLabel = $request->filled('status') ? ' — ' . ucfirst($request->status) : '';
        $pdf = Pdf::loadView('admin.enrollments_pdf', compact('enrollments', 'filterLabel'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('enrollments.pdf');
    }
}
