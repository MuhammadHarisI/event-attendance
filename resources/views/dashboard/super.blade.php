<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Super User Dashboard
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header Dashboard --}}
            <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h3 class="text-2xl font-bold text-gray-800">
                        Selamat Datang, {{ auth()->user()->name }}
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Kelola event dan pantau aktivitas sistem dari dashboard ini.
                    </p>
                </div>

                <div class="flex gap-3">

                    <a
                        href="{{ route('events.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300"
                    >
                        Lihat Semua Event
                    </a>

                    <a
                        href="{{ route('events.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                    >
                        + Tambah Event
                    </a>

                </div>

            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Total Event --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">
                        Total Event
                    </div>

                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalEvents }}
                    </div>
                </div>

                {{-- Draft --}}
                <a
                    href="{{ route('events.index', ['status' => 'draft']) }}"
                    class="block bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition"
                >
                    <div class="text-sm text-gray-500">
                        Draft
                    </div>

                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $draftEvents }}
                    </div>

                    <p class="mt-1 text-xs text-blue-500">
                        Lihat event draft
                    </p>
                </a>

                {{-- Active --}}
                <a
                    href="{{ route('events.index', ['status' => 'active']) }}"
                    class="block bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition"
                >
                    <div class="text-sm text-gray-500">
                        Active
                    </div>

                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $activeEvents }}
                    </div>

                    <p class="mt-1 text-xs text-green-500">
                        Lihat event aktif
                    </p>
                </a>

                {{-- Finished --}}
                <a
                    href="{{ route('events.index', ['status' => 'finished']) }}"
                    class="block bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition"
                >
                    <div class="text-sm text-gray-500">
                        Finished
                    </div>

                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $finishedEvents }}
                    </div>

                    <p class="mt-1 text-xs text-red-500">
                        Lihat event selesai
                    </p>
                </a>

                {{-- Total Peserta --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">
                        Total Peserta
                    </div>

                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalParticipants }}
                    </div>
                </div>

                {{-- Total Kehadiran --}}
                {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">
                        Total Kehadiran
                    </div>

                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalAttendances }}
                    </div>

                    @if ($totalAttendances === 0)
                        <p class="mt-1 text-xs text-gray-500">
                            Belum ada data kehadiran.
                        </p>
                    @endif
                </div> --}}

                {{-- Persentase Kehadiran --}}
                {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">
                        Persentase Kehadiran
                    </div>

                    <div class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $attendancePercentage }}%
                    </div>

                    @if ($totalParticipants === 0)
                        <p class="mt-1 text-xs text-gray-500">
                            Belum ada peserta terdaftar.
                        </p>
                    @elseif ($totalAttendances === 0)
                        <p class="mt-1 text-xs text-gray-500">
                            Belum ada peserta yang melakukan absensi.
                        </p>
                    @endif
                </div> --}}

            </div>

            {{-- Quick Actions --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Quick Actions
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Akses cepat ke fitur utama sistem.
                    </p>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                        {{-- Kelola Event --}}
                        <a
                            href="{{ route('events.index') }}"
                            class="block border rounded-lg p-4 hover:bg-gray-50 transition"
                        >
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <svg
                                        class="w-5 h-5 text-blue-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">
                                        Kelola Event
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Lihat dan kelola semua event
                                    </p>
                                </div>

                            </div>
                        </a>


                        {{-- Tambah Event --}}
                        <a
                            href="{{ route('events.create') }}"
                            class="block border rounded-lg p-4 hover:bg-gray-50 transition"
                        >
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                                    <svg
                                        class="w-5 h-5 text-green-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 4v16m8-8H4"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">
                                        Tambah Event
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Buat event baru
                                    </p>
                                </div>

                            </div>
                        </a>


                        {{-- Kelola Peserta --}}
                        <a
                            href="{{ route('participants.index') }}"
                            class="block border rounded-lg p-4 hover:bg-gray-50 transition"
                        >
                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                                    <svg
                                        class="w-5 h-5 text-indigo-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                        >
                                            <path
                                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                            />
                                            <circle
                                                cx="9"
                                                cy="7"
                                                r="4"
                                            />
                                            <path
                                                d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                                            />
                                        </path>
                                    </svg>
                                </div>

                                <div>
                                    <p class="font-semibold text-gray-800">
                                        Kelola Peserta
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Kelola data peserta
                                    </p>
                                </div>

                            </div>
                        </a>

                    </div>

                </div>

            </div>

            {{-- Event Aktif --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <div class="flex items-center justify-between">

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Event Aktif
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Event yang sedang membuka absensi.
                            </p>
                            
                        </div>

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            {{ $activeEvents }} Active
                        </span>

                    </div>

                    <div class="mt-4 space-y-3">

                        @forelse ($activeEventsList as $event)

                            @php
                                $percentage = $event->participants_count > 0
                                    ? round(
                                        ($event->attendances_count / $event->participants_count) * 100
                                    )
                                    : 0;
                            @endphp

                            <div class="border rounded-lg p-4">

                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                                    <div>

                                        <h4 class="font-semibold text-gray-900">
                                            {{ $event->name }}
                                        </h4>

                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $event->location ?? 'Lokasi belum ditentukan' }}
                                        </p>

                                    </div>

                                    <div class="flex flex-wrap gap-2">

                                        <a
                                            href="{{ route('events.attendances.index', $event) }}"
                                            class="inline-flex items-center px-3 py-2 rounded-md bg-green-50 text-sm font-medium text-green-700 hover:bg-green-100"
                                        >
                                            Absensi
                                        </a>

                                        <a
                                            href="{{ route('events.qr', $event) }}"
                                            class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-50 text-sm font-medium text-indigo-700 hover:bg-indigo-100"
                                        >
                                            QR Code
                                        </a>

                                        <a
                                            href="{{ route('events.show', $event) }}"
                                            class="inline-flex items-center px-3 py-2 rounded-md bg-gray-100 text-sm font-medium text-gray-700 hover:bg-gray-200"
                                        >
                                            Detail
                                        </a>

                                    </div>

                                </div>

                                <div class="mt-4">

                                    <div class="flex items-center justify-between mb-1">

                                        <span class="text-sm text-gray-600">
                                            Kehadiran
                                        </span>

                                        <span class="text-sm font-semibold text-gray-800">
                                            {{ $event->attendances_count }}
                                            /
                                            {{ $event->participants_count }}
                                            ({{ $percentage }}%)
                                        </span>

                                    </div>

                                    <div class="w-full bg-gray-200 rounded-full h-2.5">

                                        <div
                                            class="bg-green-600 h-2.5 rounded-full"
                                            style="width: {{ $percentage }}%"
                                        ></div>

                                    </div>

                                </div>

                            </div>
                            

                        @empty

                            <div class="border border-dashed rounded-lg p-6 text-center">
    
                                <p class="text-gray-500">
                                    Tidak ada event yang sedang aktif.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

                @if ($activeEvents > 0)
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-6">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            <span>
                                Data event aktif diperbarui otomatis setiap 10 detik.
                            </span>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Event Terbaru --}}
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Event Terbaru
                    </h3>

                    <div class="mt-4 overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Event
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Lokasi
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Mulai
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Status
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @forelse ($latestEvents as $event)

                                    <tr>

                                        <td class="px-4 py-3">
                                            {{ $event->name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $event->location ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $event->start_at->format('d M Y, H:i') }}
                                        </td>

                                        <td class="px-4 py-3">

                                            @if ($event->status === 'draft')

                                                <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                                    Draft
                                                </span>

                                            @elseif ($event->status === 'active')

                                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                                    Active
                                                </span>

                                            @else

                                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-700">
                                                    Finished
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-4 py-3">

                                            <div class="flex flex-wrap items-center gap-2">

                                                <a
                                                    href="{{ route('events.show', $event) }}"
                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-md bg-gray-100 text-xs font-medium text-gray-700 hover:bg-gray-200"
                                                >
                                                    Detail
                                                </a>

                                                @if ($event->status === 'active')
                                                    <a
                                                        href="{{ route('events.attendances.index', $event) }}"
                                                        class="inline-flex items-center px-2.5 py-1.5 rounded-md bg-green-50 text-xs font-medium text-green-700 hover:bg-green-100"
                                                    >
                                                        Absensi
                                                    </a>
                                                @endif

                                                <a
                                                    href="{{ route('events.qr', $event) }}"
                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-md bg-indigo-50 text-xs font-medium text-indigo-700 hover:bg-indigo-100"
                                                >
                                                    QR
                                                </a>

                                                <a
                                                    href="{{ route('events.participants', $event) }}"
                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-md bg-blue-50 text-xs font-medium text-blue-700 hover:bg-blue-100"
                                                >
                                                    Peserta
                                                </a>

                                                <a
                                                    href="{{ route('events.attendances.export', $event) }}"
                                                    class="inline-flex items-center px-2.5 py-1.5 rounded-md bg-emerald-50 text-xs font-medium text-emerald-700 hover:bg-emerald-100"
                                                >
                                                    Export
                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="px-4 py-6 text-center text-gray-500"
                                        >
                                            Belum ada event.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@if ($activeEvents > 0)
    <script>
        setTimeout(function () {
            window.location.reload();
        }, 10000);
    </script>
@endif
</x-app-layout>