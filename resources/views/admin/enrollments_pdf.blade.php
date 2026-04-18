<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enrollments List</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 6px; color: #1e293b; }
        p.sub { text-align: center; color: #64748b; font-size: 11px; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        th { background-color: #f1f5f9; color: #475569; font-weight: bold; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .active    { background: #d1fae5; color: #065f46; }
        .completed { background: #ede9fe; color: #5b21b6; }
        .dropped   { background: #ffe4e6; color: #9f1239; }
    </style>
</head>
<body>
    <h2>Enrollment Records{{ $filterLabel ?? '' }}</h2>
    <p class="sub">Exported on {{ now()->format('d M Y, H:i') }} &nbsp;·&nbsp; {{ $enrollments->count() }} record(s)</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Reg No</th>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Enrolled At</th>
                <th>Status</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($enrollments as $i => $e)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $e->student->name ?? '—' }}</td>
                    <td>{{ $e->student->reg_no ?? '—' }}</td>
                    <td>{{ $e->course->code ?? '—' }}</td>
                    <td>{{ $e->course->name ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($e->enrolled_at)->format('d M Y') }}</td>
                    <td><span class="badge {{ $e->status }}">{{ ucfirst($e->status) }}</span></td>
                    <td>{{ $e->grade ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center">No enrollments found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
