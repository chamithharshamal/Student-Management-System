<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Spatie\SimpleExcel\SimpleExcelReader;

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
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:teachers,email|max:255',
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'required|string|max:255',
            'qualification'  => 'nullable|string|max:255',
        ]);

        Teacher::create($request->only('name', 'email', 'phone', 'specialization', 'qualification'));

        return redirect()->route('admin.teachers')->with('status', 'Teacher added successfully.');
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'phone'          => 'nullable|string|max:20',
            'specialization' => 'required|string|max:255',
            'qualification'  => 'nullable|string|max:255',
        ]);

        $teacher->update($request->only('name', 'email', 'phone', 'specialization', 'qualification'));

        return redirect()->route('admin.teachers')->with('status', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers')->with('status', 'Teacher deleted successfully.');
    }

    // ── Export ────────────────────────────────────────────────────────────────

    public function exportCsv()
    {
        $teachers = Teacher::orderBy('name')->get();

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=teachers.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($teachers) {
            $file = fopen('php://output', 'w');
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
            fputcsv($file, ['Name', 'Email', 'Phone', 'Specialization', 'Qualification']);
            foreach ($teachers as $t) {
                fputcsv($file, [$t->name, $t->email, $t->phone, $t->specialization, $t->qualification]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $teachers = Teacher::orderBy('name')->get();
        $pdf = Pdf::loadView('admin.teachers_pdf', compact('teachers'));
        return $pdf->download('teachers.pdf');
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
            $reader   = SimpleExcelReader::create($filePath, $extension);
            $added    = 0;
            $skipped  = 0;

            $reader->getRows()->each(function (array $row) use (&$added, &$skipped) {
                $name           = $row['name']           ?? $row['Name']           ?? null;
                $email          = $row['email']          ?? $row['Email']          ?? null;
                $phone          = $row['phone']          ?? $row['Phone']          ?? null;
                $specialization = $row['specialization'] ?? $row['Specialization'] ?? null;
                $qualification  = $row['qualification']  ?? $row['Qualification']  ?? null;

                if ($name && $email) {
                    if (Teacher::where('email', $email)->exists()) { $skipped++; return; }
                    Teacher::create(compact('name', 'email', 'phone', 'specialization', 'qualification'));
                    $added++;
                } else {
                    $skipped++;
                }
            });

            $msg = "Import completed! {$added} teachers added.";
            if ($skipped) $msg .= " {$skipped} rows skipped.";

            return redirect()->route('admin.teachers')->with('status', $msg);

        } catch (\Exception $e) {
            return redirect()->route('admin.teachers')
                ->withErrors(['file' => 'Error processing file: ' . $e->getMessage()]);
        }
    }
}
