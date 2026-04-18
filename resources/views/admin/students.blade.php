@extends('layouts.admin')

@php
    $header = 'Students';
    $eyebrow = 'Manage student records';
@endphp

@section('content')
    <div id="studentsPage" class="w-full transition duration-200">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 md:hidden">Students</h1>
            <div class="hidden md:block"></div>
            <div class="flex items-center gap-3 w-full md:w-auto relative">
                
                <!-- Export Dropdown Wrapper -->
                <div class="relative inline-block text-left flex-1 md:flex-none">
                    <button type="button" id="exportButton" onclick="toggleExportDropdown()"
                            class="w-full justify-center inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 hover:shadow">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export
                        <svg class="-mr-1 ml-1 h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="exportDropdown" class="hidden absolute right-0 z-10 mt-2 w-44 origin-top-right rounded-2xl bg-white shadow-lg ring-1 ring-slate-900/5 focus:outline-none transition-all duration-200">
                        <div class="p-1">
                            <a href="{{ route('admin.students.export.csv', request()->query()) }}" class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                <svg class="mr-3 h-4 w-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Excel (CSV)
                            </a>
                            <a href="{{ route('admin.students.export.pdf', request()->query()) }}" target="_blank" class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                <svg class="mr-3 h-4 w-4 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                PDF Document
                            </a>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="openImportModal()"
                    class="flex-1 md:flex-none justify-center inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 hover:shadow">
                    <svg class="h-4 w-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Import
                </button>

                <button type="button" onclick="openStudentModal()"
                    class="flex-1 md:flex-none justify-center inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-5 py-3 text-sm font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Add Student
                </button>
            </div>
        </div>

        <section
            class="min-w-0 rounded-[28px] bg-white p-6 shadow-[0_10px_30px_rgba(18,38,104,0.07)] ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Students</h2>
                    <p class="mt-2 text-base text-slate-500">All students stored in the system.</p>
                </div>
                <span class="rounded-full bg-slate-100 px-4 py-1.5 text-sm font-medium text-slate-800">
                    {{ $students->count() }} total
                </span>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.students') }}" class="mt-6 flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search students by name or address..."
                        class="block w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)] placeholder:text-slate-500" style="padding-left: 2.75rem; padding-right: 1rem;">
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full sm:w-auto">
                        <select name="sort" class="block w-full cursor-pointer appearance-none rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-4 pr-10 text-sm text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                            <option value="">Sort by Reg No</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Reg No (Ascending)</option>
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Reg No (Descending)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4">
                            <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>

                    <button type="submit" class="flex w-full sm:w-auto items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-px hover:bg-slate-800 hover:shadow-md">
                        Filter
                    </button>

                    @if(request()->anyFilled(['search', 'sort']))
                    <a href="{{ route('admin.students') }}" class="flex w-full sm:w-auto items-center justify-center rounded-2xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 shadow-sm transition hover:-translate-y-px hover:bg-slate-50 hover:text-slate-900 min-w-24">
                        Clear
                    </a>
                    @endif
                </div>
            </form>

            @if (session('status'))
                <div id="statusNotification" class="mt-5 rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 transition-opacity duration-500">
                    {{ session('status') }}
                </div>
                <script>
                    setTimeout(() => {
                        const notification = document.getElementById('statusNotification');
                        if (notification) {
                            notification.style.opacity = '0';
                            setTimeout(() => notification.remove(), 500); // Wait for transition before removing
                        }
                    }, 3000);
                </script>
            @endif

            <div class="mt-5 overflow-hidden rounded-3xl border border-slate-100">
                <table class="min-w-full divide-y divide-slate-100 text-left text-base">
                    <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-5 py-4 font-medium">Reg No</th>
                            <th class="px-5 py-4 font-medium">Student</th>
                            <th class="px-5 py-4 font-medium">Address</th>
                            <th class="px-5 py-4 font-medium">DOB</th>
                            <th class="px-5 py-4 font-medium">Age</th>
                            <th class="px-5 py-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($students as $student)
                            <tr>
                                <td class="px-5 py-4 font-medium text-slate-900">{{ $student->reg_no }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $student->name }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $student->address }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ \Carbon\Carbon::parse($student->dob)->format('Y-m-d') }}
                                </td>
                                <td class="px-5 py-4 text-slate-600">{{ $student->age }}</td>
                                <td class="px-5 py-4 text-right text-sm">
                                    <button type="button" onclick="openEditModal({{ $student->id }}, '{{ addslashes($student->reg_no) }}', '{{ addslashes($student->name) }}', '{{ addslashes($student->address) }}', '{{ \Carbon\Carbon::parse($student->dob)->format('Y-m-d') }}')" class="mr-1 inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button type="button" onclick="openDeleteModal({{ $student->id }})" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-rose-50 hover:text-rose-600">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-base text-slate-500">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

@endsection

@push('modals')
    <div id="studentModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div
            class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <!-- ... modal content ... -->
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">Add Student</h2>
                    </div>
                    <button type="button" onclick="closeStudentModal()"
                        class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                        aria-label="Close dialog">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]">
                            <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
            </div>

            @if ($errors->any())
                <div class="mx-6 mt-5 rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-5 px-6 py-6">
                @csrf

                <div class="space-y-2">
                    <label for="reg_no" class="block text-sm font-medium text-slate-700">Registration No</label>
                    <input id="reg_no" name="reg_no" type="text" value="{{ old('reg_no', $nextRegNo ?? '') }}" required
                        class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-slate-700">Student Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>

                <div class="space-y-2">
                    <label for="address" class="block text-sm font-medium text-slate-700">Address</label>
                    <input id="address" name="address" type="text" value="{{ old('address') }}" required
                        class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>

                <div class="space-y-2">
                    <label for="dob" class="block text-sm font-medium text-slate-700">Date of Birth</label>
                    <input id="dob" name="dob" type="date" value="{{ old('dob') }}" required
                        class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeStudentModal()"
                        class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">
                        Add Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="editStudentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">Edit Student</h2>
                    </div>
                    <button type="button" onclick="closeEditModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
            <form id="edit_form" method="POST" action="" class="space-y-5 px-6 py-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label for="edit_reg_no" class="block text-sm font-medium text-slate-700">Registration No</label>
                    <input id="edit_reg_no" name="reg_no" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="edit_name" class="block text-sm font-medium text-slate-700">Student Name</label>
                    <input id="edit_name" name="name" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="edit_address" class="block text-sm font-medium text-slate-700">Address</label>
                    <input id="edit_address" name="address" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="edit_dob" class="block text-sm font-medium text-slate-700">Date of Birth</label>
                    <input id="edit_dob" name="dob" type="date" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteStudentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-sm text-center overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="p-6">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-rose-100 p-3 text-rose-600">
                    <svg viewBox="0 0 24 24" class="h-8 w-8 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-slate-900">Delete Student</h3>
                <p class="mb-6 text-sm text-slate-500">Are you sure you want to delete this student? This action cannot be undone.</p>
                <div class="flex items-center gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <form id="delete_form" method="POST" action="" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-3xl bg-rose-600 px-4 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(225,29,72,0.28)] transition hover:-translate-y-px hover:shadow-[0_16px_32px_rgba(225,29,72,0.34)]">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="importStudentModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold text-slate-900">Import Students</h2>
                        <p class="text-sm text-slate-500">Upload an Excel or CSV file to import records.</p>
                    </div>
                    <button type="button" onclick="closeImportModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.students.import') }}" enctype="multipart/form-data" class="px-6 py-6 space-y-6">
                @csrf
                
                <!-- Upload Area -->
                <label id="dropzone" for="file-upload" class="group cursor-pointer block relative overflow-hidden rounded-[24px] border-2 border-dashed border-slate-300 bg-slate-50 transition-all hover:bg-slate-100 hover:border-slate-400"
                     ondragover="event.preventDefault(); this.classList.add('border-emerald-500', 'bg-emerald-50'); this.classList.remove('border-slate-300', 'bg-slate-50');"
                     ondragleave="event.preventDefault(); this.classList.remove('border-emerald-500', 'bg-emerald-50'); this.classList.add('border-slate-300', 'bg-slate-50');"
                     ondrop="event.preventDefault(); this.classList.remove('border-emerald-500', 'bg-emerald-50'); this.classList.add('border-slate-300', 'bg-slate-50'); handleDrop(event)">
                    
                    <div class="px-6 py-10 flex flex-col items-center justify-center pointer-events-none">
                        <div id="upload-icon-default" class="mb-4 rounded-full bg-white p-4 shadow-sm ring-1 ring-slate-900/5 transition-transform group-hover:scale-105">
                            <svg class="h-8 w-8 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                        </div>
                        
                        <div id="upload-icon-success" class="mb-4 hidden rounded-full bg-emerald-100 p-4 transition-transform scale-100">
                            <svg class="h-8 w-8 text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        
                        <h3 id="upload-text" class="text-base font-semibold text-slate-900">Click to upload</h3>
                        <p id="drag-text" class="mt-1 text-sm text-slate-500">or drag and drop here</p>
                        
                        <p id="fileNameDisplay" class="mt-2 text-sm font-semibold text-emerald-600 break-all px-4 text-center hidden"></p>
                        
                        <p id="format-text" class="mt-4 text-[13px] text-slate-400">Supports .CSV, .XLS, .XLSX</p>
                    </div>
                    
                    <input id="file-upload" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required onchange="updateFileName(this)">
                </label>

                <!-- Expected Columns -->
                <div class="rounded-[20px] bg-white border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-5 py-3.5 flex items-center justify-between">
                        <span class="text-[11px] font-bold tracking-wider text-slate-500 uppercase">File Format Guide</span>
                    </div>
                    <div class="px-5 py-5">
                        <p class="text-sm text-slate-600 mb-3">Your spreadsheet must contain these exact column headers:</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">reg_no</span>
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">name</span>
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">address</span>
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">dob</span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeImportModal()" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none">Cancel</button>
                    <button type="submit" class="flex-1 rounded-xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-sm font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)] focus:outline-none">Import Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const studentModal = document.getElementById('studentModal');
        const editStudentModal = document.getElementById('editStudentModal');
        const importStudentModal = document.getElementById('importStudentModal');
        const appWrapper = document.getElementById('app-wrapper');

        function openImportModal() {
            if (importStudentModal) {
                importStudentModal.classList.remove('hidden');
                importStudentModal.classList.add('flex');
            }
            if (appWrapper) {
                appWrapper.style.filter = 'blur(16px)';
                appWrapper.style.transform = 'scale(0.98)';
                appWrapper.style.pointerEvents = 'none';
            }
            document.body.classList.add('overflow-hidden');
        }

        function closeImportModal() {
            if (importStudentModal) {
                importStudentModal.classList.add('hidden');
                importStudentModal.classList.remove('flex');
            }
            if (appWrapper) {
                appWrapper.style.filter = '';
                appWrapper.style.transform = '';
                appWrapper.style.pointerEvents = '';
            }
            document.body.classList.remove('overflow-hidden');
        }

        function handleDrop(event) {
            const fileInput = document.getElementById('file-upload');
            if (event.dataTransfer.files && event.dataTransfer.files.length > 0) {
                fileInput.files = event.dataTransfer.files;
                updateFileName(fileInput);
            }
        }

        function updateFileName(input) {
            const display = document.getElementById('fileNameDisplay');
            const dropzone = document.getElementById('dropzone');
            const defaultIcon = document.getElementById('upload-icon-default');
            const successIcon = document.getElementById('upload-icon-success');
            const uploadText = document.getElementById('upload-text');
            const dragText = document.getElementById('drag-text');
            const formatText = document.getElementById('format-text');

            if (input.files && input.files[0]) {
                display.textContent = input.files[0].name;
                display.classList.remove('hidden');
                dropzone.classList.add('border-emerald-500', 'bg-emerald-50');
                dropzone.classList.remove('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
                defaultIcon.classList.add('hidden');
                successIcon.classList.remove('hidden');
                uploadText.textContent = 'File ready to import';
                dragText.classList.add('hidden');
                formatText.classList.add('hidden');
            } else {
                display.textContent = '';
                display.classList.add('hidden');
                dropzone.classList.remove('border-emerald-500', 'bg-emerald-50');
                dropzone.classList.add('border-slate-300', 'bg-slate-50', 'hover:bg-slate-100');
                defaultIcon.classList.remove('hidden');
                successIcon.classList.add('hidden');
                uploadText.textContent = 'Click to upload';
                dragText.classList.remove('hidden');
                formatText.classList.remove('hidden');
            }
        }

        function openStudentModal() {
            if (studentModal) {
                studentModal.classList.remove('hidden');
                studentModal.classList.add('flex');
            }
            if (appWrapper) {
                appWrapper.style.filter = 'blur(16px)';
                appWrapper.style.transform = 'scale(0.98)';
                appWrapper.style.pointerEvents = 'none';
            }
            document.body.classList.add('overflow-hidden');
        }

        function closeStudentModal() {
            if (studentModal) {
                studentModal.classList.add('hidden');
                studentModal.classList.remove('flex');
            }
            if (appWrapper) {
                appWrapper.style.filter = '';
                appWrapper.style.transform = '';
                appWrapper.style.pointerEvents = '';
            }
            document.body.classList.remove('overflow-hidden');
        }

        function openEditModal(id, reg_no, name, address, dob) {
            document.getElementById('edit_form').action = `/students/${id}`;
            document.getElementById('edit_reg_no').value = reg_no;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_dob').value = dob;

            if (editStudentModal) {
                editStudentModal.classList.remove('hidden');
                editStudentModal.classList.add('flex');
            }
            if (appWrapper) {
                appWrapper.style.filter = 'blur(16px)';
                appWrapper.style.transform = 'scale(0.98)';
                appWrapper.style.pointerEvents = 'none';
            }
            document.body.classList.add('overflow-hidden');
        }

        function closeEditModal() {
            if (editStudentModal) {
                editStudentModal.classList.add('hidden');
                editStudentModal.classList.remove('flex');
            }
            if (appWrapper) {
                appWrapper.style.filter = '';
                appWrapper.style.transform = '';
                appWrapper.style.pointerEvents = '';
            }
            document.body.classList.remove('overflow-hidden');
        }

        if (studentModal && {{ $errors->any() ? 'true' : 'false' }}) {
            // Ideally we should check if its edit or create errors, but this handles create for now.
            openStudentModal();
        }

        studentModal?.addEventListener('click', (event) => {
            if (event.target === studentModal) {
                closeStudentModal();
            }
        });
        
        editStudentModal?.addEventListener('click', (event) => {
            if (event.target === editStudentModal) {
                closeEditModal();
            }
        });
        const deleteStudentModal = document.getElementById('deleteStudentModal');
        
        function openDeleteModal(id) {
            document.getElementById('delete_form').action = `/students/${id}`;
            if (deleteStudentModal) {
                deleteStudentModal.classList.remove('hidden');
                deleteStudentModal.classList.add('flex');
            }
            if (appWrapper) {
                appWrapper.style.filter = 'blur(16px)';
                appWrapper.style.transform = 'scale(0.98)';
                appWrapper.style.pointerEvents = 'none';
            }
            document.body.classList.add('overflow-hidden');
        }

        function closeDeleteModal() {
            if (deleteStudentModal) {
                deleteStudentModal.classList.add('hidden');
                deleteStudentModal.classList.remove('flex');
            }
            if (!studentModal.classList.contains('flex') && !editStudentModal.classList.contains('flex') && appWrapper) {
                appWrapper.style.filter = '';
                appWrapper.style.transform = '';
                appWrapper.style.pointerEvents = '';
                document.body.classList.remove('overflow-hidden');
            }
        }

        deleteStudentModal?.addEventListener('click', (event) => {
            if (event.target === deleteStudentModal) {
                closeDeleteModal();
            }
        });

        importStudentModal?.addEventListener('click', (event) => {
            if (event.target === importStudentModal) {
                closeImportModal();
            }
        });

        function toggleExportDropdown() {
            const dropdown = document.getElementById('exportDropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('exportDropdown');
            const button = document.getElementById('exportButton');
            if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
@endpush