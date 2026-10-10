<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg p-6 text-center">

                {{-- Icon sukses --}}
                <div class="mb-6">
                    <div class="mx-auto flex items-center justify-center w-16 h-16 bg-green-100 rounded-full">
                        <svg
                            class="w-8 h-8 text-green-600"
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
                </div>

                {{-- Judul --}}
                <h1 class="text-2xl font-bold text-gray-800">
                    Absensi Berhasil!
                </h1>

                {{-- Nama peserta --}}
                <p class="mt-4 text-lg text-gray-700">
                    Haloo,
                    <span class="font-bold text-gray-900">
                        {{ $participant->name }}
                    </span>
                    👋
                </p>

                <p class="mt-2 text-sm text-gray-600">
                    Kamu berhasil melakukan absensi.
                </p>

                {{-- Detail event --}}
                <div class="mt-6 bg-gray-50 border rounded-lg p-4 text-left">

                    <div>
                        <p class="text-xs text-gray-500">
                            Event
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $event->name }}
                        </p>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-500">
                            Waktu Absensi
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $attendance->checked_in_at->format('d M Y, H:i:s') }}
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="mt-4">
                        <p class="text-xs text-gray-500">
                            Status
                        </p>

                        <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Hadir
                        </span>
                    </div>

                </div>

                {{-- Navigasi --}}
                <div class="mt-6">

                    <a
                        href="{{ route('attendance.form', $event->qr_token) }}"
                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Absen Peserta Lain
                    </a>

                </div>

                {{-- Informasi tambahan --}}
                <p class="mt-4 text-xs text-gray-500">
                    Jika kamu sudah selesai, kamu dapat menutup halaman ini.
                </p>

            </div>
        </div>
    </div>
</x-guest-layout>