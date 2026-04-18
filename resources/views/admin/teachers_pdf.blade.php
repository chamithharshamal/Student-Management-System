<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Teachers List</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        h2 { text-align: center; margin-bottom: 6px; color: #1e293b; }
        p.sub { text-align: center; color: #64748b; font-size: 11px; margin-top: 0; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #cbd5e1; padding: 9px 12px; text-align: left; }
        th { background-color: #f1f5f9; color: #475569; font-weight: bold; }
        tr:nth-child(even) { background-color: #f8fafc; }
    </style>
</head>
<body>
    <h2>Teachers Directory</h2>
    <p class="sub">Exported on {{ now()->format('d M Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Specialization</th>
                <th>Qualification</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teachers as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->name }}</td>
                    <td>{{ $t->email }}</td>
                    <td>{{ $t->phone ?? '—' }}</td>
                    <td>{{ $t->specialization }}</td>
                    <td>{{ $t->qualification ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center">No teachers found.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
