<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg p-6">

                {{-- Header --}}
                <div class="text-center mb-6">

                    <div class="mx-auto flex items-center justify-center w-14 h-14 bg-indigo-100 rounded-full">
                        <svg
                            class="w-7 h-7 text-indigo-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 12c0 5.591 3.824 10.29 9 11.622C17.176 22.29 21 17.591 21 12c0-1.043-.133-2.055-.382-3.016z"
                            />
                        </svg>
                    </div>

                    <h1 class="mt-4 text-2xl font-bold text-gray-800">
                        {{ $event->name }}
                    </h1>

                    <div class="mt-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Absensi Aktif
                        </span>
                    </div>

                    <p class="mt-3 text-sm text-gray-600">
                        Silakan masukkan Identity Number untuk melakukan absensi.
                    </p>

                </div>

                {{-- Error umum --}}
                @if ($errors->any())
                    <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-4">
                        <p class="text-sm font-medium text-red-800">
                            Absensi gagal
                        </p>

                        <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form --}}
                <form
                    method="POST"
                    action="{{ route('attendance.check', $event->qr_token) }}"
                >
                    @csrf

                    <div>
                        <label
                            for="identity_number"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Identity Number
                        </label>

                        <input
                            type="text"
                            name="identity_number"
                            id="identity_number"
                            value="{{ old('identity_number') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Masukkan NIM / NIK / NIP"
                            autocomplete="off"
                            autocapitalize="characters"
                            required
                            autofocus
                        >

                        @error('identity_number')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="mt-6 w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Absen Sekarang
                    </button>
                </form>

                {{-- Informasi --}}
                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">
                        Pastikan Identity Number yang dimasukkan sudah benar.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>