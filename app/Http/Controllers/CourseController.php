<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

class CourseController extends Controller
{
    public function index()
    {
        $courses  = Course::with('teacher')->latest()->get();
        $teachers = Teacher::all();
        return view('admin.courses', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'        => 'required|string|unique:courses,code|max:50',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits'     => 'required|integer|min:1',
            'teacher_id'  => 'nullable|exists:teachers,id',
        ]);

        Course::create($request->only('code', 'name', 'description', 'credits', 'teacher_id'));

        return redirect()->route('admin.courses')->with('status', 'Course added successfully.');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'code'        => 'required|string|max:50|unique:courses,code,' . $course->id,
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits'     => 'required|integer|min:1',
            'teacher_id'  => 'nullable|exists:teachers,id',
        ]);

        $course->update($request->only('code', 'name', 'description', 'credits', 'teacher_id'));

        return redirect()->route('admin.courses')->with('status', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')->with('status', 'Course deleted successfully.');
    }

    // ── Export ────────────────────────────────────────────────────────────────

    public function exportCsv()
    {
        $courses = Course::with('teacher')->orderBy('code')->get();

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=courses.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($courses) {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['Code', 'Name', 'Description', 'Credits', 'Teacher']);
            foreach ($courses as $c) {
                fputcsv($file, [$c->code, $c->name, $c->description, $c->credits, $c->teacher->name ?? '']);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $courses = Course::with('teacher')->orderBy('code')->get();
        $pdf = Pdf::loadView('admin.courses_pdf', compact('courses'));
        return $pdf->download('courses.pdf');
    }

    // ── Import ────────────────────────────────────────────────────────────────

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        $file      = $request->file('file');
        $filePath  = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();

        try {
            $reader = SimpleExcelReader::create($filePath, $extension)
                ->headersToSnakeCase();
            $added   = 0;
            $skipped = 0;

            $reader->getRows()->each(function (array $row) use (&$added, &$skipped) {
                $code        = trim($row['code'] ?? $row['course_code'] ?? null);
                $name        = trim($row['name'] ?? $row['course_name'] ?? $row['title'] ?? null);
                $description = trim($row['description'] ?? $row['desc'] ?? null);
                $credits     = trim($row['credits'] ?? $row['credit_hours'] ?? 3);

                if ($code && $name) {
                    if (Course::where('code', $code)->exists()) { 
                        $skipped++; 
                        return; 
                    }
                    Course::create([
                        'code' => $code,
                        'name' => $name,
                        'description' => $description,
                        'credits' => $credits
                    ]);
                    $added++;
                } else {
                    $skipped++;
                }
            });

            $msg = "Import completed! {$added} courses added.";
            if ($skipped > 0) {
                $msg .= " {$skipped} rows were skipped (duplicates or missing data).";
            }

            return redirect()->route('admin.courses')->with('status', $msg);

        } catch (\Exception $e) {
            return redirect()->route('admin.courses')
                ->withErrors(['file' => 'Error processing file: ' . $e->getMessage()]);
        }
    }
}
