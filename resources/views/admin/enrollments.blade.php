@extends('layouts.admin')

@php
    $header = 'Enrollments';
    $eyebrow = 'Manage student course enrollments';
@endphp

@section('content')
    <div id="enrollmentsPage" class="w-full space-y-5">

        {{-- Top bar --}}
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 md:hidden">Enrollments</h1>
            {{-- Search & filter --}}
            <form method="GET" action="{{ route('admin.enrollments') }}" class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search student or course…"
                    class="w-full md:w-64 rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-800 outline-none transition focus:border-slate-400 focus:ring-2 focus:ring-slate-200">
                <select name="status" class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-slate-400">
                    <option value="">All statuses</option>
                    <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="dropped"   {{ request('status') === 'dropped'   ? 'selected' : '' }}>Dropped</option>
                </select>
                <button type="submit" class="rounded-2xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:-translate-y-px hover:bg-slate-700">Filter</button>
                @if(request()->anyFilled(['search','status']))
                    <a href="{{ route('admin.enrollments') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Clear</a>
                @endif
            </form>
            <div class="flex items-center gap-3">
                {{-- Export Dropdown --}}
                <div class="relative inline-block text-left">
                    <button type="button" id="exportEnrollBtn" onclick="toggleEnrollExport()"
                            class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 hover:shadow">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export
                        <svg class="-mr-1 ml-1 h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="enrollExportDropdown" class="hidden absolute right-0 z-10 mt-2 w-44 origin-top-right rounded-2xl bg-white shadow-lg ring-1 ring-slate-900/5">
                        <div class="p-1">
                            <a href="{{ route('admin.enrollments.export.csv', array_filter(['search' => request('search'), 'status' => request('status')])) }}" class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="mr-3 h-4 w-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Excel (CSV)
                            </a>
                            <a href="{{ route('admin.enrollments.export.pdf', array_filter(['search' => request('search'), 'status' => request('status')])) }}" target="_blank" class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="mr-3 h-4 w-4 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                PDF Document
                            </a>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="openEnrollModal()"
                    class="inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-5 py-3 text-sm font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Enroll Student
                </button>
            </div>
        </div>

        {{-- Stats row --}}
        @php
            $total     = $enrollments->total();
            $active    = \App\Models\Enrollment::where('status','active')->count();
            $completed = \App\Models\Enrollment::where('status','completed')->count();
            $dropped   = \App\Models\Enrollment::where('status','dropped')->count();
        @endphp
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">
            @foreach([
                ['label'=>'Total',     'value'=>$total,     'color'=>'slate'],
                ['label'=>'Active',    'value'=>$active,    'color'=>'emerald'],
                ['label'=>'Completed', 'value'=>$completed, 'color'=>'violet'],
                ['label'=>'Dropped',   'value'=>$dropped,   'color'=>'rose'],
            ] as $stat)
            <div class="rounded-[20px] border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $stat['label'] }}</p>
                <p class="mt-1 text-3xl font-bold text-slate-900">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Table --}}
        <section class="rounded-[24px] border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Student</th>
                            <th class="px-5 py-4">Course</th>
                            <th class="px-5 py-4 hidden md:table-cell">Teacher</th>
                            <th class="px-5 py-4">Enrolled</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 hidden sm:table-cell">Grade</th>
                            <th class="px-5 py-4 text-right pr-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($enrollments as $enrollment)
                            <tr class="transition hover:bg-slate-50/50">
                                {{-- Student --}}
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-slate-900">{{ $enrollment->student->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $enrollment->student->reg_no }}</div>
                                </td>
                                {{-- Course --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="font-medium text-slate-800">{{ $enrollment->course->name }}</div>
                                    <span class="inline-block rounded-md bg-slate-100 px-1.5 py-0.5 text-[11px] font-mono font-semibold text-slate-600">{{ $enrollment->course->code }}</span>
                                </td>
                                {{-- Teacher --}}
                                <td class="px-5 py-4 whitespace-nowrap hidden md:table-cell text-slate-500">
                                    {{ $enrollment->course->teacher->name ?? '—' }}
                                </td>
                                {{-- Enrolled at --}}
                                <td class="px-5 py-4 whitespace-nowrap text-slate-500">
                                    {{ \Carbon\Carbon::parse($enrollment->enrolled_at)->format('d M Y') }}
                                </td>
                                {{-- Status badge --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @php
                                        $dot = match($enrollment->status) {
                                            'active'    => '#10b981',
                                            'completed' => '#8b5cf6',
                                            'dropped'   => '#f43f5e',
                                            default     => '#94a3b8',
                                        };
                                        $label = match($enrollment->status) {
                                            'active'    => 'Active',
                                            'completed' => 'Completed',
                                            'dropped'   => 'Dropped',
                                            default     => ucfirst($enrollment->status),
                                        };
                                    @endphp
                                    <span style="display:inline-flex; align-items:center; gap:6px; font-size:13px; font-weight:600; color:#1e293b;">
                                        <span style="width:8px; height:8px; border-radius:50%; background:{{ $dot }}; flex-shrink:0; display:inline-block;"></span>
                                        {{ $label }}
                                    </span>
                                </td>
                                {{-- Grade --}}
                                <td class="px-5 py-4 hidden sm:table-cell font-mono text-slate-700">
                                    {{ $enrollment->grade ?? '—' }}
                                </td>
                                {{-- Actions --}}
                                <td class="px-5 py-4 text-right pr-6">
                                    <button type="button"
                                        onclick="openEditModal({{ $enrollment->id }}, '{{ $enrollment->status }}', '{{ addslashes($enrollment->grade) }}')"
                                        class="mr-1 inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button type="button"
                                        onclick="openDeleteModal({{ $enrollment->id }})"
                                        class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-rose-50 hover:text-rose-600">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-14 text-center">
                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 mb-3">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                    </div>
                                    <p class="text-base font-medium text-slate-500">No enrollments found.</p>
                                    <p class="text-sm text-slate-400 mt-1">Use the "Enroll Student" button to get started.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($enrollments->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $enrollments->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection

@push('modals')
    {{-- Enroll Modal --}}
    <div id="enrollModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Enroll Student</h2>
                    <p class="text-sm text-slate-400 mt-0.5">Assign a student to a course</p>
                </div>
                <button type="button" onclick="closeEnrollModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" /></svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.enrollments.store') }}" class="space-y-5 px-6 py-6">
                @csrf
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Student</label>
                    <select name="student_id" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                        <option value="">— Select student —</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->reg_no }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Course</label>
                    <select name="course_id" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                        <option value="">— Select course —</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->code }} — {{ $course->name }}{{ $course->teacher ? ' ('.$course->teacher->name.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1 space-y-2">
                        <label class="block text-sm font-medium text-slate-700">Enroll Date</label>
                        <input type="date" name="enrolled_at" value="{{ old('enrolled_at', date('Y-m-d')) }}" required
                            class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                    </div>
                    <div class="w-40 space-y-2">
                        <label class="block text-sm font-medium text-slate-700">Status</label>
                        <select name="status" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="dropped">Dropped</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeEnrollModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px">Enroll Student</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editEnrollModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm">
        <div class="w-full max-w-md overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5 flex items-start justify-between gap-4">
                <h2 class="text-2xl font-semibold text-slate-900">Update Enrollment</h2>
                <button type="button" onclick="closeEditModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            <form id="edit_enroll_form" method="POST" action="" class="space-y-5 px-6 py-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Status</label>
                    <select id="edit_status" name="status" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="dropped">Dropped</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-slate-700">Grade <span class="text-slate-400 font-normal">(optional)</span></label>
                    <input id="edit_grade" type="text" name="grade" maxlength="10" placeholder="e.g. A, B+, 85"
                        class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteEnrollModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm">
        <div class="w-full max-w-sm text-center overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="p-6">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-rose-100 p-3 text-rose-600">
                    <svg viewBox="0 0 24 24" class="h-8 w-8 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-slate-900">Remove Enrollment</h3>
                <p class="mb-6 text-sm text-slate-500">Are you sure you want to remove this enrollment? This action cannot be undone.</p>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <form id="delete_enroll_form" method="POST" action="" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-3xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(225,29,72,0.28)] transition hover:-translate-y-px">Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEnrollModal() {
            const m = document.getElementById('enrollModal');
            m.classList.remove('hidden'); m.classList.add('flex');
        }
        function closeEnrollModal() {
            const m = document.getElementById('enrollModal');
            m.classList.add('hidden'); m.classList.remove('flex');
        }
        function openEditModal(id, status, grade) {
            const m = document.getElementById('editEnrollModal');
            document.getElementById('edit_enroll_form').action = `/enrollments/${id}`;
            document.getElementById('edit_status').value = status;
            document.getElementById('edit_grade').value  = grade;
            m.classList.remove('hidden'); m.classList.add('flex');
        }
        function closeEditModal() {
            const m = document.getElementById('editEnrollModal');
            m.classList.add('hidden'); m.classList.remove('flex');
        }
        function openDeleteModal(id) {
            const m = document.getElementById('deleteEnrollModal');
            document.getElementById('delete_enroll_form').action = `/enrollments/${id}`;
            m.classList.remove('hidden'); m.classList.add('flex');
        }
        function closeDeleteModal() {
            const m = document.getElementById('deleteEnrollModal');
            m.classList.add('hidden'); m.classList.remove('flex');
        }

        @if($errors->has('duplicate'))
            openEnrollModal();
        @elseif($errors->any())
            openEnrollModal();
        @endif

        function toggleEnrollExport() {
            document.getElementById('enrollExportDropdown').classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const btn = document.getElementById('exportEnrollBtn');
            if (btn && !btn.contains(e.target)) {
                document.getElementById('enrollExportDropdown').classList.add('hidden');
            }
        });
    </script>
@endpush
