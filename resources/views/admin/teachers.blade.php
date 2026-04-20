@extends('layouts.admin')

@php
    $header = 'Teachers';
    $eyebrow = 'Manage academic staff';
@endphp

@section('content')
    <div id="teachersPage" class="w-full transition duration-200">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 md:hidden">Teachers</h1>
            <div class="hidden md:block"></div>
            <div class="flex items-center gap-3 w-full md:w-auto relative">

                {{-- Export Dropdown --}}
                <div class="relative inline-block text-left flex-1 md:flex-none">
                    <button type="button" id="exportTeacherBtn" onclick="toggleTeacherExport()"
                            class="w-full justify-center inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 hover:shadow">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                        Export
                        <svg class="-mr-1 ml-1 h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="teacherExportDropdown" class="hidden absolute right-0 z-10 mt-2 w-44 origin-top-right rounded-2xl bg-white shadow-lg ring-1 ring-slate-900/5">
                        <div class="p-1">
                            <a href="{{ route('admin.teachers.export.csv') }}" class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="mr-3 h-4 w-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Excel (CSV)
                            </a>
                            <a href="{{ route('admin.teachers.export.pdf') }}" target="_blank" class="group flex items-center rounded-xl px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                                <svg class="mr-3 h-4 w-4 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                PDF Document
                            </a>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="openTeacherImportModal()"
                    class="flex-1 md:flex-none justify-center inline-flex items-center gap-2 rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-slate-50 hover:shadow">
                    <svg class="h-4 w-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                    Import
                </button>

                <button type="button" onclick="openTeacherModal()"
                    class="flex-1 md:flex-none justify-center inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-5 py-3 text-sm font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Add Teacher
                </button>
            </div>
        </div>

        <section class="rounded-[24px] border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-4 first:pl-6 last:pr-6 whitespace-nowrap">Name</th>
                            <th class="px-5 py-4 whitespace-nowrap">Email</th>
                            <th class="px-5 py-4 whitespace-nowrap">Phone</th>
                            <th class="px-5 py-4 whitespace-nowrap">Specialization</th>
                            <th class="px-5 py-4 text-right first:pl-6 last:pr-6 whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($teachers as $teacher)
                            <tr class="transition hover:bg-slate-50/50">
                                <td class="px-5 py-4 first:pl-6 last:pr-6 whitespace-nowrap">
                                    <div class="font-medium text-slate-900">{{ $teacher->name }}</div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ $teacher->email }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">{{ $teacher->phone ?? 'N/A' }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-[13px] font-semibold text-emerald-800 ring-1 ring-inset ring-emerald-600/20">
                                        <div class="h-1.5 w-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                        {{ $teacher->specialization }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right first:pl-6 last:pr-6">
                                    <button type="button" onclick="openEditModal({{ $teacher->id }}, '{{ addslashes($teacher->name) }}', '{{ addslashes($teacher->email) }}', '{{ addslashes($teacher->phone) }}', '{{ addslashes($teacher->specialization) }}')" class="mr-2 inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button type="button" onclick="openDeleteModal({{ $teacher->id }})" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-rose-50 hover:text-rose-600">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-base text-slate-500">No teachers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection

@push('modals')
    <!-- Add Modal -->
    <div id="teacherModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div><h2 class="text-2xl font-semibold text-slate-900">Add Teacher</h2></div>
                    <button type="button" onclick="closeTeacherModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" /></svg>
                    </button>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.teachers.store') }}" class="space-y-5 px-6 py-6">
                @csrf
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-slate-700">Teacher Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="specialization" class="block text-sm font-medium text-slate-700">Specialization</label>
                    <input id="specialization" name="specialization" type="text" value="{{ old('specialization') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeTeacherModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">Add Teacher</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editTeacherModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div><h2 class="text-2xl font-semibold text-slate-900">Edit Teacher</h2></div>
                    <button type="button" onclick="closeEditModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
            <form id="edit_form" method="POST" action="" class="space-y-5 px-6 py-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label for="edit_name" class="block text-sm font-medium text-slate-700">Teacher Name</label>
                    <input id="edit_name" name="name" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="edit_email" class="block text-sm font-medium text-slate-700">Email Address</label>
                    <input id="edit_email" name="email" type="email" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="edit_phone" class="block text-sm font-medium text-slate-700">Phone</label>
                    <input id="edit_phone" name="phone" type="text" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="edit_specialization" class="block text-sm font-medium text-slate-700">Specialization</label>
                    <input id="edit_specialization" name="specialization" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteTeacherModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-sm text-center overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="p-6">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-rose-100 p-3 text-rose-600">
                    <svg viewBox="0 0 24 24" class="h-8 w-8 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-slate-900">Delete Teacher</h3>
                <p class="mb-6 text-sm text-slate-500">Are you sure you want to delete this teacher? This action cannot be undone.</p>
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

    <script>
        function openTeacherModal() {
            const modal = document.getElementById('teacherModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.firstElementChild.classList.add('scale-100', 'opacity-100');
                modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeTeacherModal() {
            const modal = document.getElementById('teacherModal');
            modal.firstElementChild.classList.remove('scale-100', 'opacity-100');
            modal.firstElementChild.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function openEditModal(id, name, email, phone, specialization) {
            const modal = document.getElementById('editTeacherModal');
            const form = document.getElementById('edit_form');
            form.action = `/teachers/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_specialization').value = specialization;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.firstElementChild.classList.add('scale-100', 'opacity-100');
                modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('editTeacherModal');
            modal.firstElementChild.classList.remove('scale-100', 'opacity-100');
            modal.firstElementChild.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function openDeleteModal(id) {
            const modal = document.getElementById('deleteTeacherModal');
            const form = document.getElementById('delete_form');
            form.action = `/teachers/${id}`;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Init animation states
            modal.firstElementChild.classList.add('scale-95', 'opacity-0', 'transition-all', 'duration-300');
            
            setTimeout(() => {
                modal.firstElementChild.classList.add('scale-100', 'opacity-100');
                modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteTeacherModal');
            modal.firstElementChild.classList.remove('scale-100', 'opacity-100');
            modal.firstElementChild.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        @if($errors->any() && session('modal') == 'edit')
            openEditModal({{ old('id') }}, '{{ old('name') }}', '{{ old('email') }}', '{{ old('phone') }}', '{{ old('specialization') }}');
        @elseif($errors->any())
            openTeacherModal();
        @endif

        function toggleTeacherExport() {
            const d = document.getElementById('teacherExportDropdown');
            d.classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            if (!document.getElementById('exportTeacherBtn').contains(e.target)) {
                document.getElementById('teacherExportDropdown').classList.add('hidden');
            }
        });

        function openTeacherImportModal() {
            const m = document.getElementById('teacherImportModal');
            m.classList.remove('hidden'); m.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }
        function closeTeacherImportModal() {
            const m = document.getElementById('teacherImportModal');
            m.classList.add('hidden'); m.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function handleTeacherDrop(event) {
            const fileInput = document.getElementById('teacher_import_file');
            if (event.dataTransfer.files && event.dataTransfer.files.length > 0) {
                fileInput.files = event.dataTransfer.files;
                updateTeacherFileName(fileInput);
            }
        }

        function updateTeacherFileName(input) {
            const display = document.getElementById('teacherFileNameDisplay');
            const dropzone = document.getElementById('teacherDropzone');
            const defaultIcon = document.getElementById('teacher-upload-icon-default');
            const successIcon = document.getElementById('teacher-upload-icon-success');
            const uploadText = document.getElementById('teacher-upload-text');
            const dragText = document.getElementById('teacher-drag-text');
            const formatText = document.getElementById('teacher-format-text');

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

        @if($errors->has('file'))
            openTeacherImportModal();
        @endif
    </script>

    {{-- Import Modal --}}
    <div id="teacherImportModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5 flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900">Import Teachers</h2>
                    <p class="text-sm text-slate-500">Upload an Excel or CSV file to import records.</p>
                </div>
                <button type="button" onclick="closeTeacherImportModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                    <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            @if($errors->has('file'))
                <div class="mx-6 mt-5 rounded-3xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $errors->first('file') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.teachers.import') }}" enctype="multipart/form-data" class="px-6 py-6 space-y-6">
                @csrf
                
                <!-- Upload Area -->
                <label id="teacherDropzone" for="teacher_import_file" class="group cursor-pointer block relative overflow-hidden rounded-[24px] border-2 border-dashed border-slate-300 bg-slate-50 transition-all hover:bg-slate-100 hover:border-slate-400"
                     ondragover="event.preventDefault(); this.classList.add('border-emerald-500', 'bg-emerald-50'); this.classList.remove('border-slate-300', 'bg-slate-50');"
                     ondragleave="event.preventDefault(); this.classList.remove('border-emerald-500', 'bg-emerald-50'); this.classList.add('border-slate-300', 'bg-slate-50');"
                     ondrop="event.preventDefault(); this.classList.remove('border-emerald-500', 'bg-emerald-50'); this.classList.add('border-slate-300', 'bg-slate-50'); handleTeacherDrop(event)">
                    
                    <div class="px-6 py-10 flex flex-col items-center justify-center pointer-events-none">
                        <div id="teacher-upload-icon-default" class="mb-4 rounded-full bg-white p-4 shadow-sm ring-1 ring-slate-900/5 transition-transform group-hover:scale-105">
                            <svg class="h-8 w-8 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                        </div>
                        
                        <div id="teacher-upload-icon-success" class="mb-4 hidden rounded-full bg-emerald-100 p-4 transition-transform scale-100">
                            <svg class="h-8 w-8 text-emerald-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        
                        <h3 id="teacher-upload-text" class="text-base font-semibold text-slate-900">Click to upload</h3>
                        <p id="teacher-drag-text" class="mt-1 text-sm text-slate-500">or drag and drop here</p>
                        
                        <p id="teacherFileNameDisplay" class="mt-2 text-sm font-semibold text-emerald-600 break-all px-4 text-center hidden"></p>
                        
                        <p id="teacher-format-text" class="mt-4 text-[13px] text-slate-400">Supports .CSV, .XLS, .XLSX</p>
                    </div>
                    
                    <input id="teacher_import_file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv" required onchange="updateTeacherFileName(this)">
                </label>

                <!-- Expected Columns -->
                <div class="rounded-[20px] bg-white border border-slate-200 overflow-hidden">
                    <div class="bg-slate-50 border-b border-slate-200 px-5 py-3.5 flex items-center justify-between">
                        <span class="text-[11px] font-bold tracking-wider text-slate-500 uppercase">File Format Guide</span>
                    </div>
                    <div class="px-5 py-5">
                        <p class="text-sm text-slate-600 mb-3">Your spreadsheet must contain these exact column headers:</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">name</span>
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">email</span>
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">phone</span>
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">specialization</span>
                            <span class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-700 font-mono ring-1 ring-inset ring-slate-200/50">qualification</span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeTeacherImportModal()" class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none">Cancel</button>
                    <button type="submit" class="flex-1 rounded-xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-sm font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)] focus:outline-none">Import Data</button>
                </div>
            </form>
        </div>
    </div>
@endpush
