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
            <div class="flex items-center gap-3 w-full md:w-auto">
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
    </script>
@endpush
