<x-app-layout>

    <<x-slot name="header">

        <div class="flex flex-col gap-4">

            <div class="flex justify-between items-center">

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Event Management
                </h2>

                <a
                    href="{{ route('events.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                    + Tambah Event
                </a>

            </div>

            {{-- Filter Event --}}
            <div>

                <form
                    method="GET"
                    action="{{ route('events.index') }}"
                    class="flex flex-col sm:flex-row gap-3"
                >

                    <select
                        name="status"
                        class="w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Semua Status</option>

                        <option
                            value="draft"
                            {{ request('status') === 'draft' ? 'selected' : '' }}
                        >
                            Draft
                        </option>

                        <option
                            value="active"
                            {{ request('status') === 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="finished"
                            {{ request('status') === 'finished' ? 'selected' : '' }}
                        >
                            Finished
                        </option>
                    </select>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700"
                    >
                        Filter
                    </button>

                    @if (request('status'))
                        <a
                            href="{{ route('events.index') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200"
                        >
                            Reset
                        </a>
                    @endif

                </form>

            </div>

        </div>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Daftar Event
                    </h3>

                    @if ($events->count())

                        <div class="overflow-x-auto">

                            <table class="min-w-full border border-gray-200">

                                <thead class="bg-gray-100">

                                    <tr>
                                        <th class="px-4 py-3 border text-left">
                                            Nama Event
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Lokasi
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Mulai
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Selesai
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Status
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Peserta
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Hadir
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Kehadiran
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Aksi
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($events as $event)

                                        <tr>

                                            <td class="px-4 py-3 border">
                                                {{ $event->name }}
                                            </td>

                                            <td class="px-4 py-3 border">
                                                {{ $event->location ?? '-' }}
                                            </td>

                                            <td class="px-4 py-3 border">
                                                {{ $event->start_at->format('d M Y, H:i') }}
                                            </td>

                                            <td class="px-4 py-3 border">
                                                {{ $event->end_at->format('d M Y, H:i') }}
                                            </td>

                                            <td class="px-4 py-3 border">

                                                @if ($event->status === 'draft')
                                                    <span class="px-2 py-1 text-xs rounded bg-gray-200">
                                                        Draft
                                                    </span>

                                                @elseif ($event->status === 'active')
                                                    <span class="px-2 py-1 text-xs rounded bg-green-200 text-green-800">
                                                        Active
                                                    </span>

                                                @else
                                                    <span class="px-2 py-1 text-xs rounded bg-red-200 text-red-800">
                                                        Finished
                                                    </span>
                                                @endif

                                            </td>

                                            {{-- Total Peserta --}}
                                            <td class="px-4 py-3 border">
                                                {{ $event->participants_count }}
                                            </td>

                                            {{-- Total Hadir --}}
                                            <td class="px-4 py-3 border">
                                                {{ $event->attendances_count }}
                                            </td>

                                            {{-- Persentase Kehadiran --}}
                                            <td class="px-4 py-3 border">

                                                @php
                                                    $attendancePercentage = $event->participants_count > 0
                                                        ? round(
                                                            ($event->attendances_count / $event->participants_count) * 100
                                                        )
                                                        : 0;
                                                @endphp

                                                <span class="font-medium">
                                                    {{ $attendancePercentage }}%
                                                </span>

                                            </td>

                                            <td class="px-4 py-3 border">

                                                <div class="flex gap-2 items-center">

                                                    <a
                                                        href="{{ route('events.show', $event) }}"
                                                        class="text-blue-600 hover:underline"
                                                    >
                                                        Detail
                                                    </a>

                                                    <a
                                                        href="{{ route('events.edit', $event) }}"
                                                        class="text-yellow-600 hover:underline"
                                                    >
                                                        Edit
                                                    </a>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('events.destroy', $event) }}"
                                                        onsubmit="return confirm('Yakin ingin menghapus event ini?')"
                                                    >

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="text-red-600 hover:underline"
                                                        >
                                                            Hapus
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-4">
                            {{ $events->links() }}
                        </div>

                    @else

                        <div class="text-center py-10">

                            @if (request('status'))

                                <div class="text-gray-500">
                                    Tidak ada event dengan status
                                    <span class="font-semibold">
                                        {{ ucfirst(request('status')) }}
                                    </span>.
                                </div>

                                <div class="mt-4">
                                    <a
                                        href="{{ route('events.index') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200"
                                    >
                                        Reset Filter
                                    </a>
                                </div>

                            @else

                                <div class="text-gray-500">
                                    Belum ada event.
                                </div>

                                <div class="mt-4">
                                    <a
                                        href="{{ route('events.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                    >
                                        + Tambah Event
                                    </a>
                                </div>

                            @endif

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>