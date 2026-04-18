@extends('layouts.admin')

@php
    $header = 'Courses';
    $eyebrow = 'Manage academic courses';
@endphp

@section('content')
    <div id="coursesPage" class="w-full transition duration-200">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900 md:hidden">Courses</h1>
            <div class="hidden md:block"></div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <button type="button" onclick="openCourseModal()"
                    class="flex-1 md:flex-none justify-center inline-flex items-center gap-2 rounded-2xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-5 py-3 text-sm font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Add Course
                </button>
            </div>
        </div>

        <section class="rounded-[24px] border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50/80 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-4 first:pl-6 last:pr-6 whitespace-nowrap">Code</th>
                            <th class="px-5 py-4 whitespace-nowrap">Name</th>
                            <th class="px-5 py-4 whitespace-nowrap hidden sm:table-cell">Credits</th>
                            <th class="px-5 py-4 whitespace-nowrap">Assigned Teacher</th>
                            <th class="px-5 py-4 text-right first:pl-6 last:pr-6 whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($courses as $course)
                            <tr class="transition hover:bg-slate-50/50">
                                <td class="px-5 py-4 first:pl-6 last:pr-6 whitespace-nowrap">
                                    <div class="font-bold font-mono text-slate-900 border border-slate-200 bg-slate-100 rounded-lg px-2 py-1 inline-block">{{ $course->code }}</div>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap font-medium text-slate-900">{{ $course->name }}</td>
                                <td class="px-5 py-4 whitespace-nowrap hidden sm:table-cell">{{ $course->credits }}</td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($course->teacher)
                                        <div class="flex items-center gap-2">
                                            <div class="h-6 w-6 rounded-full bg-[linear-gradient(135deg,#c4b5fd_0%,#8b5cf6_100%)] flex items-center justify-center text-[10px] font-bold text-white shadow-sm">
                                                {{ substr($course->teacher->name, 0, 1) }}
                                            </div>
                                            <span class="text-slate-700 font-medium">{{ $course->teacher->name }}</span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-500">Unassigned</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right first:pl-6 last:pr-6">
                                    <button type="button" onclick="openEditModal({{ $course->id }}, '{{ addslashes($course->code) }}', '{{ addslashes($course->name) }}', '{{ addslashes($course->description) }}', {{ $course->credits }}, '{{ $course->teacher_id ?? '' }}')" class="mr-2 inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button type="button" onclick="openDeleteModal({{ $course->id }})" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-400 transition hover:bg-rose-50 hover:text-rose-600">
                                        <svg class="h-4 w-4 fill-none stroke-current stroke-[2]" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-base text-slate-500">No courses found.</td>
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
    <div id="courseModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div><h2 class="text-2xl font-semibold text-slate-900">Add Course</h2></div>
                    <button type="button" onclick="closeCourseModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" /></svg>
                    </button>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-5 px-6 py-6">
                @csrf
                <div class="flex gap-4">
                    <div class="space-y-2 flex-1">
                        <label for="code" class="block text-sm font-medium text-slate-700">Course Code</label>
                        <input id="code" name="code" type="text" value="{{ old('code') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 font-mono outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]" placeholder="E.g. CS101">
                    </div>
                    <div class="space-y-2 w-32">
                        <label for="credits" class="block text-sm font-medium text-slate-700">Credits</label>
                        <input id="credits" name="credits" type="number" min="1" value="{{ old('credits') ?? 3 }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-slate-700">Course Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="teacher_id" class="block text-sm font-medium text-slate-700">Assign Teacher</label>
                    <select id="teacher_id" name="teacher_id" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                        <option value="">-- Unassigned --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }} ({{ $teacher->specialization }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeCourseModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">Add Course</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editCourseModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-lg overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-start justify-between gap-4">
                    <div><h2 class="text-2xl font-semibold text-slate-900">Edit Course</h2></div>
                    <button type="button" onclick="closeEditModal()" class="rounded-full p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close dialog">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            </div>
            <form id="edit_form" method="POST" action="" class="space-y-5 px-6 py-6">
                @csrf
                @method('PUT')
                <div class="flex gap-4">
                    <div class="space-y-2 flex-1">
                        <label for="edit_code" class="block text-sm font-medium text-slate-700">Course Code</label>
                        <input id="edit_code" name="code" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 font-mono outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                    </div>
                    <div class="space-y-2 w-32">
                        <label for="edit_credits" class="block text-sm font-medium text-slate-700">Credits</label>
                        <input id="edit_credits" name="credits" type="number" min="1" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="edit_name" class="block text-sm font-medium text-slate-700">Course Name</label>
                    <input id="edit_name" name="name" type="text" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                </div>
                <div class="space-y-2">
                    <label for="edit_teacher_id" class="block text-sm font-medium text-slate-700">Assign Teacher</label>
                    <select id="edit_teacher_id" name="teacher_id" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 outline-none transition focus:border-slate-800 focus:bg-white focus:shadow-[0_0_0_4px_rgba(15,23,42,0.10)]">
                        <option value="">-- Unassigned --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->specialization }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="flex-1 rounded-3xl border border-slate-200 bg-white px-4 py-3.5 text-base font-semibold text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">Cancel</button>
                    <button type="submit" class="flex-1 rounded-3xl bg-[linear-gradient(135deg,#1e293b_0%,#0f172a_100%)] px-4 py-3.5 text-base font-semibold text-white shadow-[0_18px_38px_rgba(15,23,42,0.28)] transition hover:-translate-y-px hover:shadow-[0_22px_42px_rgba(15,23,42,0.34)]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteCourseModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 px-4 py-6 backdrop-blur-sm transition-all duration-300">
        <div class="w-full max-w-sm text-center overflow-hidden rounded-[28px] bg-white ring-1 ring-slate-200/50 shadow-[0_24px_80px_-12px_rgba(18,38,104,0.4)]">
            <div class="p-6">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-rose-100 p-3 text-rose-600">
                    <svg viewBox="0 0 24 24" class="h-8 w-8 fill-none stroke-current stroke-[2]"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-slate-900">Delete Course</h3>
                <p class="mb-6 text-sm text-slate-500">Are you sure you want to delete this course? This action cannot be undone.</p>
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
        function openCourseModal() {
            const modal = document.getElementById('courseModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.firstElementChild.classList.add('scale-100', 'opacity-100');
                modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeCourseModal() {
            const modal = document.getElementById('courseModal');
            modal.firstElementChild.classList.remove('scale-100', 'opacity-100');
            modal.firstElementChild.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function openEditModal(id, code, name, description, credits, teacher_id) {
            const modal = document.getElementById('editCourseModal');
            const form = document.getElementById('edit_form');
            form.action = `/courses/${id}`;
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_credits').value = credits;
            document.getElementById('edit_teacher_id').value = teacher_id;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.firstElementChild.classList.add('scale-100', 'opacity-100');
                modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('editCourseModal');
            modal.firstElementChild.classList.remove('scale-100', 'opacity-100');
            modal.firstElementChild.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function openDeleteModal(id) {
            const modal = document.getElementById('deleteCourseModal');
            const form = document.getElementById('delete_form');
            form.action = `/courses/${id}`;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.firstElementChild.classList.add('scale-95', 'opacity-0', 'transition-all', 'duration-300');
            
            setTimeout(() => {
                modal.firstElementChild.classList.add('scale-100', 'opacity-100');
                modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteCourseModal');
            modal.firstElementChild.classList.remove('scale-100', 'opacity-100');
            modal.firstElementChild.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        @if($errors->any() && session('modal') == 'edit')
            openEditModal({{ old('id') }}, '{{ old('code') }}', '{{ old('name') }}', '{{ old('description') }}', {{ old('credits') }}, '{{ old('teacher_id') }}');
        @elseif($errors->any())
            openCourseModal();
        @endif
    </script>
@endpush
