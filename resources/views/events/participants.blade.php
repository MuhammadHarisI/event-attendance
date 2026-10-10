<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Participant Event
            </h2>

            <a
                href="{{ route('events.show', $event) }}"
                class="text-sm text-gray-600 hover:text-gray-900"
            >
                ← Kembali ke Event
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-flash-message />

            @if (session('import_empty'))
                <div class="mb-4 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-4 rounded">
                    <h4 class="font-semibold mb-1">
                        Tidak ada data untuk di-import
                    </h4>

                    <p class="text-sm">
                        {{ session('import_empty') }}
                    </p>
                </div>
            @endif
            
            @if (session('import_summary'))
                <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-4 rounded">
                    <h4 class="font-semibold mb-2">
                        Import berhasil
                    </h4>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        <li>
                            Participant baru:
                            <strong>{{ session('import_summary.new') }}</strong>
                        </li>

                        <li>
                            Participant sudah ada:
                            <strong>{{ session('import_summary.existing') }}</strong>
                        </li>

                        <li>
                            Participant berhasil dihubungkan ke event:
                            <strong>{{ session('import_summary.attached') }}</strong>
                        </li>
                    </ul>
                </div>
            @endif


            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('import_header_errors'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-4 rounded">
                    <h4 class="font-semibold mb-2">
                        Format kolom file tidak sesuai
                    </h4>

                    <p class="text-sm mb-2">
                        File yang diupload tidak memiliki kolom wajib berikut:
                    </p>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach (session('import_header_errors') as $header)
                            <li>
                                {{ $header }}
                            </li>
                        @endforeach
                    </ul>

                    <p class="mt-3 text-xs">
                        Gunakan template Excel yang tersedia untuk memastikan format kolom sudah benar.
                    </p>
                </div>
            @endif

        
            @if (session('import_errors'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-4 rounded">
                    <h4 class="font-semibold mb-2">
                        Import gagal karena ada data yang tidak valid
                    </h4>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach (session('import_errors') as $failure)
                            <li>
                                Baris {{ $failure->row() }}:
                                {{ implode(', ', $failure->errors()) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ $event->name }}
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Tambahkan participant yang sudah terdaftar di database.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('events.participants.add', $event) }}"
                        class="mt-6"
                    >
                        @csrf

                        <div>
                            <label
                                for="participant_id"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Pilih Participant
                            </label>

                            <select
                                name="participant_id"
                                id="participant_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required
                            >
                                <option value="">
                                    -- Pilih Participant --
                                </option>

                                @foreach ($participants as $participant)
                                    <option value="{{ $participant->id }}">
                                        {{ $participant->identity_number }}
                                        - {{ $participant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if ($participants->count())
                            <button
                                type="submit"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                            >
                                Tambahkan Participant
                            </button>
                        @else
                            <p class="mt-4 text-sm text-gray-500">
                                Semua participant sudah terdaftar pada event ini.
                            </p>
                        @endif
                    </form>
                     {{-- Import Participant dari Excel --}}
                    <div class="mt-8 border-t pt-6">
                        <h4 class="text-md font-semibold text-gray-900">
                            Import Participant dari Excel
                        </h4>

                        <p class="mt-1 text-sm text-gray-500">
                            Upload file Excel untuk menambahkan banyak participant sekaligus.
                        </p>
                            <a
                                href="{{ route('participants.import.template') }}"
                                class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                            >
                                Download Template Excel
                            </a>
                        <form
                            action="{{ route('events.participants.import', $event) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="mt-4"
                        >
                            @csrf

                            <div>
                                <label
                                    for="file"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Pilih File Import
                                </label>

                                <input
                                    type="file"
                                    name="file"
                                    id="file"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    accept=".xlsx,.xls,.csv"
                                    required
                                >

                                <p class="mt-1 text-xs text-gray-500">
                                     Format yang didukung: XLSX, XLS, atau CSV. Maksimal 5 MB.
                                </p>

                                <div class="mt-2 rounded-md bg-yellow-50 border border-yellow-200 px-3 py-2 text-xs text-yellow-800">
                                    <strong>Tips:</strong>
                                    Jika Identity Number diawali angka 0, pastikan kolom
                                    <strong>Identity Number</strong> di Excel menggunakan format
                                    <strong>Text</strong> agar angka 0 di depan tidak hilang.
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700"
                            >
                                Import Data Participant
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>