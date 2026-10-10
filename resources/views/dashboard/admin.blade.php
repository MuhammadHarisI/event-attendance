<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>
                        Selamat datang, {{ auth()->user()->name }}!
                    </p>

                    <p class="mt-2">
                        Kamu login sebagai Admin.
                    </p>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold text-gray-900">
                        Event Saya
                    </h3>

                    <div class="mt-4 space-y-3">
                        @forelse ($events as $event)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">
                                            {{ $event->name }}
                                        </h4>

                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $event->location ?? 'Lokasi belum ditentukan' }}
                                        </p>

                                        <div class="mt-2">
                                            @if ($event->status === 'draft')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Draft
                                                </span>
                                            @elseif ($event->status === 'active')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @elseif ($event->status === 'finished')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Finished
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    

                                    <div class="flex items-center gap-3 flex-wrap">

                                            @if ($event->status === 'active')
                                                <a
                                                href="{{ route('events.attendances.index', $event) }}"
                                                class="inline-flex items-center px-3 py-2 rounded-md bg-green-50 text-sm font-medium text-green-700 hover:bg-green-100"
                                            >
                                                Buka Absensi
                                            </a>
                                            @endif
                                             <a
                                                href="{{ route('events.qr', $event) }}"
                                                class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-50 text-sm font-medium text-indigo-700 hover:bg-indigo-100"
                                            >
                                                QR Code
                                            </a>

                                            <a
                                                href="{{ route('events.show', $event) }}"
                                                class="inline-flex items-center px-3 py-2 rounded-md bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                            >
                                                Lihat Event
                                            </a>

                                        </div>
                                    </div>

                                {{-- Statistik Peserta --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4">
                                    

                                    {{-- Total Peserta --}}
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-500">
                                            Total Peserta
                                        </p>

                                        <p class="text-2xl font-bold text-gray-900">
                                            {{ $event->participants_count }}
                                        </p>
                                    </div>

                                    {{-- Sudah Hadir --}}
                                    <div class="bg-green-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-500">
                                            Sudah Hadir
                                        </p>

                                        <p class="text-2xl font-bold text-green-600">
                                            {{ $event->attendances_count }}
                                        </p>
                                    </div>

                                    {{-- Belum Hadir --}}
                                    <div class="bg-red-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-500">
                                            Belum Hadir
                                        </p>

                                        <p class="text-2xl font-bold text-red-600">
                                            {{ max(0, $event->participants_count - $event->attendances_count) }}
                                        </p>
                                    </div>

                                    {{-- Persentase Kehadiran --}}
                                    @php
                                        $attendancePercentage = $event->participants_count > 0
                                            ? round(($event->attendances_count / $event->participants_count) * 100)
                                            : 0;
                                    @endphp

                                    <div class="mt-4">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">
                                                Persentase Kehadiran
                                            </span>

                                            <span class="text-sm font-semibold text-gray-900">
                                                {{ $attendancePercentage }}%
                                            </span>
                                        </div>

                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div
                                                class="bg-green-600 h-2.5 rounded-full"
                                                style="width: {{ $attendancePercentage }}%"
                                            ></div>
                                        </div>
                                        @if ($event->status === 'active')
                                            @if ($event->participants_count === 0)
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Belum ada peserta yang terdaftar.
                                                </p>
                                            @elseif ($event->attendances_count === 0)
                                                <p class="mt-2 text-sm text-yellow-600">
                                                    Belum ada peserta yang hadir.
                                                </p>
                                            @elseif ($event->attendances_count < $event->participants_count)
                                                <p class="mt-2 text-sm text-blue-600">
                                                    Absensi sedang berlangsung.
                                                </p>
                                            @else
                                                <p class="mt-2 text-sm text-green-600 font-medium">
                                                    Semua peserta sudah hadir.
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">
                                Belum ada event yang ditugaskan kepada kamu.
                            </p>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>