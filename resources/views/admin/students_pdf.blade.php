<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1e293b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>

    <h2>Registered Students</h2>

    <table>
        <thead>
            <tr>
                <th>Reg No</th>
                <th>Student Name</th>
                <th>Address</th>
                <th>Date of Birth</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr>
                    <td>{{ $student->reg_no }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->dob)->format('Y-m-d') }}</td>
                    <td>{{ $student->age }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center">No students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
