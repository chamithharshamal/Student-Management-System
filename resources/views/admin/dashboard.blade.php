@extends('layouts.admin')

@php
    $header = 'Dashboard';
    $eyebrow = 'Overview of the system';
@endphp

@section('content')
    <div class="space-y-6">
        <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="rounded-[26px] bg-white p-6 shadow-[0_10px_30px_rgba(18,38,104,0.07)] ring-1 ring-slate-100">
                    <p class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                    <div class="mt-4 flex items-end justify-between gap-4">
                        <div>
                            <h2 class="text-4xl font-semibold tracking-tight text-slate-900">{{ $stat['value'] }}</h2>
                            <p class="mt-2 text-sm text-slate-500">{{ $stat['detail'] }}</p>
                        </div>
                        <div class="grid h-13 w-13 place-items-center rounded-2xl
                            @if($stat['accent'] === 'blue') bg-blue-50 text-blue-600
                            @elseif($stat['accent'] === 'violet') bg-violet-50 text-violet-600
                            @elseif($stat['accent'] === 'emerald') bg-emerald-50 text-emerald-600
                            @else bg-amber-50 text-amber-600 @endif">
                            <span class="h-3 w-3 rounded-full bg-current"></span>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-[28px] bg-white p-6 shadow-[0_10px_30px_rgba(18,38,104,0.07)] ring-1 ring-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900">Recent Students</h3>
                        <p class="mt-1 text-sm text-slate-500">Latest records already stored in the system.</p>
                    </div>
                    <span class="rounded-full bg-[#eef2ff] px-3 py-1 text-xs font-medium text-[#2f63f0]">Live data</span>
                </div>

                <div class="mt-5 overflow-hidden rounded-3xl border border-slate-100">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-medium">Reg No</th>
                            <th class="px-4 py-3 font-medium">Student</th>
                            <th class="px-4 py-3 font-medium">Address</th>
                            <th class="px-4 py-3 font-medium">Age</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($recentStudents as $student)
                            <tr>
                                <td class="px-4 py-4 font-medium text-slate-900">{{ $student->reg_no }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $student->name }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $student->address }}</td>
                                <td class="px-4 py-4 text-slate-600">{{ $student->age }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">No student records yet.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-[28px] bg-white p-6 shadow-[0_10px_30px_rgba(18,38,104,0.07)] ring-1 ring-slate-100">
                <h3 class="text-xl font-semibold text-slate-900">Module Access</h3>
                <div class="mt-4 grid gap-3">
                    @foreach ([
                        ['title' => 'Students', 'desc' => 'View and manage student profiles'],
                        ['title' => 'Courses', 'desc' => 'Create subjects and class offerings'],
                        ['title' => 'Teachers', 'desc' => 'Assign teaching staff'],
                        ['title' => 'Grades', 'desc' => 'Track exam and class results'],
                    ] as $module)
                        <div class="rounded-2xl bg-[#f8faff] px-4 py-3 ring-1 ring-slate-100">
                            <p class="font-medium text-slate-900">{{ $module['title'] }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $module['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
