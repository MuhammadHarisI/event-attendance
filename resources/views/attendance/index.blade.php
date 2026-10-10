<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Attendance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="mb-6 rounded-md bg-green-50 border border-green-200 p-4">
                            <div class="flex items-center">

                                <div class="flex-shrink-0">
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
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                </div>

                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">
                                        {{ session('success') }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-2xl font-bold">
                            {{ $event->name }}
                        </h3>

                        <p class="mt-1 text-sm text-gray-600">
                            Daftar peserta dan status kehadiran.
                        </p>

                        <div class="mt-3">

                            @if ($event->status === 'active')

                                <div class="inline-flex items-center px-3 py-2 rounded-md bg-green-50 border border-green-200">
                                    <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>

                                    <span class="text-sm font-medium text-green-700">
                                        Absensi sedang berlangsung
                                    </span>
                                </div>

                            @elseif ($event->status === 'draft')

                                <div class="inline-flex items-center px-3 py-2 rounded-md bg-yellow-50 border border-yellow-200">
                                    <span class="w-2 h-2 mr-2 bg-yellow-500 rounded-full"></span>

                                    <span class="text-sm font-medium text-yellow-700">
                                        Event belum aktif
                                    </span>
                                </div>

                            @elseif ($event->status === 'finished')

                                <div class="inline-flex items-center px-3 py-2 rounded-md bg-red-50 border border-red-200">
                                    <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>

                                    <span class="text-sm font-medium text-red-700">
                                        Event telah selesai
                                    </span>
                                </div>

                            @endif

                        </div>

                        @if ($event->status === 'active')

                            <p class="mt-2 text-sm text-gray-500">
                                Peserta dapat melakukan absensi sekarang.
                            </p>

                        @elseif ($event->status === 'draft')

                            <p class="mt-2 text-sm text-gray-500">
                                Event belum diaktifkan. Peserta belum dapat melakukan absensi.
                            </p>

                        @elseif ($event->status === 'finished')

                            <p class="mt-2 text-sm text-gray-500">
                                Event telah selesai. Absensi sudah ditutup.
                            </p>

                        @endif

                        <form
                            method="GET"
                            action="{{ route('events.attendances.index', $event) }}"
                            class="mt-4 flex gap-2"
                        >
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari nama atau Identity Number..."
                                class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            <select
                                name="status"
                                class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>
                                    Semua
                                </option>

                                <option value="attended" {{ $status === 'attended' ? 'selected' : '' }}>
                                    Hadir
                                </option>

                                <option value="not_attended" {{ $status === 'not_attended' ? 'selected' : '' }}>
                                    Belum Hadir
                                </option>
                            </select>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                            >
                                Cari
                            </button>

                            <a
                                href="{{ route('events.attendances.index', $event) }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                            >
                                Reset
                            </a>

                        </form>

                        <div class="mt-3 flex flex-wrap gap-2">

                            <a
                                href="{{ route('events.show', $event) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                            >
                                ← Kembali ke Event
                            </a>

                            <a
                                href="{{ route('events.qr', $event) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                QR Code
                            </a>

                            <a
                                href="{{ request()->fullUrl() }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            >
                                ↻ Refresh
                            </a>

                            <a
                                href="{{ route('events.attendances.export', $event) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                            >
                                Export Excel
                            </a>

                            @if ($event->status === 'active' && auth()->user()->role === 'super_user')

                                <form
                                    method="POST"
                                    action="{{ route('events.finish', $event) }}"
                                    onsubmit="return confirmFinishEvent(this)"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        id="finish-event-button"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Selesaikan Event
                                    </button>
                                </form>

                            @endif

                        </div>

                        @if ($event->status === 'active')
                            <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span>Data otomatis diperbarui setiap 10 detik.</span>
                            </div>
                        @endif

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                        <div class="bg-gray-50 border rounded-lg p-4">
                            <p class="text-sm text-gray-500">
                                Total Peserta
                            </p>

                            <p class="mt-1 text-2xl font-bold text-gray-800">
                                {{ $totalParticipants }}
                            </p>
                        </div>

                        <div class="bg-green-50 border rounded-lg p-4">
                            <p class="text-sm text-gray-500">
                                Hadir
                            </p>

                            <p class="mt-1 text-2xl font-bold text-green-600">
                                {{ $totalAttended }}
                            </p>
                        </div>

                        <div class="bg-blue-50 border rounded-lg p-4">
                            <p class="text-sm text-gray-500">
                                Persentase Hadir
                            </p>

                            <p class="mt-1 text-2xl font-bold text-blue-600">
                                {{ $attendancePercentage }}%
                            </p>
                            <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                                <div
                                    class="bg-blue-600 h-2 rounded-full"
                                    style="width: {{ $attendancePercentage }}%"
                                ></div>
                            </div>
                        </div>

                        <div class="bg-red-50 border rounded-lg p-4">
                            <p class="text-sm text-gray-500">
                                Belum Hadir
                            </p>

                            <p class="mt-1 text-2xl font-bold text-red-600">
                                {{ $totalNotAttended }}
                            </p>
                        </div>

                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Identity Number
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Waktu Absen
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse ($participants as $participant)

                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $participant->identity_number }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $participant->name }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @if ($attendances->has($participant->id))

                                                <span class="text-green-600 font-semibold">
                                                    Hadir
                                                </span>

                                            @else

                                                <span class="text-red-600 font-semibold">
                                                    Belum Hadir
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">

                                            @if ($attendances->has($participant->id))

                                                <div>
                                                    <p class="font-medium text-gray-800">
                                                        {{ $attendances->get($participant->id)->checked_in_at->format('H:i:s') }}
                                                    </p>

                                                    <p class="text-xs text-gray-500">
                                                        {{ $attendances->get($participant->id)->checked_in_at->format('d M Y') }}
                                                    </p>
                                                </div>

                                            @else

                                                -

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="4"
                                            class="px-6 py-6 text-center text-gray-500"
                                        >
                                            Belum ada participant pada event ini.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                        <div class="mt-6">
                            {{ $participants->links() }}
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <script>
    const eventStatus = @json($event->status);

    let autoRefreshEnabled = eventStatus === 'active';
    let refreshTimer;

    function startAutoRefresh() {
        clearTimeout(refreshTimer);

        if (!autoRefreshEnabled) {
            return;
        }

        refreshTimer = setTimeout(function () {
            window.location.reload();
        }, 10000);
    }

    const searchInput = document.querySelector('input[name="search"]');
    const statusSelect = document.querySelector('select[name="status"]');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            autoRefreshEnabled = false;
            clearTimeout(refreshTimer);
        });

        searchInput.addEventListener('focus', function () {
            autoRefreshEnabled = false;
            clearTimeout(refreshTimer);
        });
    }

    if (statusSelect) {
        statusSelect.addEventListener('focus', function () {
            autoRefreshEnabled = false;
            clearTimeout(refreshTimer);
        });

        statusSelect.addEventListener('change', function () {
            autoRefreshEnabled = false;
            clearTimeout(refreshTimer);
        });
    }

    startAutoRefresh();

    function confirmFinishEvent(form) {
    const confirmed = confirm(
        'Yakin ingin menyelesaikan event ini? Setelah selesai, peserta tidak dapat melakukan absensi lagi.'
    );

    if (!confirmed) {
        return false;
    }

    const button = document.getElementById('finish-event-button');

    if (button) {
        button.disabled = true;
        button.innerText = 'Memproses...';
    }

    return true;
}
</script>
</x-app-layout>