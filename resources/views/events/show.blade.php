<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Event
            </h2>

            <div class="flex flex-wrap gap-2">

                <a
                    href="{{ route('events.edit', $event) }}"
                    class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                >
                    Edit
                </a>

                @if (auth()->user()->role === 'super_user')
                    <a
                        href="{{ route('events.admins', $event) }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                    >
                        Kelola Admin
                    </a>
                @endif
                
                <a
                    href="{{ route('events.participants', $event) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700"
                >
                    Kelola Participant
                </a>

                <a
                    href="{{ route('events.attendances.index', $event) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                >
                    Attendance
                </a>

                <a
                    href="{{ route('events.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                >
                    Kembali
                </a>
                

            </div>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-flash-message />

            @if ($errors->any())

                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif
            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    {{-- Nama Event --}}
                    <div class="mb-6">

                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $event->name }}
                        </h1>

                        <p class="text-gray-500 mt-1">
                            {{ $event->location ?? 'Lokasi belum ditentukan' }}
                        </p>

                    </div>


                    {{-- Informasi Event --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        {{-- Waktu Mulai --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Waktu Mulai
                            </p>

                            <p class="font-medium text-gray-900">
                                {{ $event->start_at->format('d M Y, H:i') }}
                            </p>

                        </div>


                        {{-- Waktu Selesai --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Waktu Selesai
                            </p>

                            <p class="font-medium text-gray-900">
                                {{ $event->end_at->format('d M Y, H:i') }}
                            </p>

                        </div>


                        {{-- Status Action --}}
                        <div class="mt-3">

                            @if ($event->status === 'draft')

                                <form
                                    method="POST"
                                    action="{{ route('events.activate', $event) }}"
                                    onsubmit="return confirm('Yakin ingin mengaktifkan event ini?')"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                                    >
                                        Aktifkan Event
                                    </button>

                                </form>

                            @elseif ($event->status === 'active')

                                <form
                                    method="POST"
                                    action="{{ route('events.finish', $event) }}"
                                    onsubmit="return confirm('Yakin ingin menyelesaikan event ini?')"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                                    >
                                        Selesaikan Event
                                    </button>

                                </form>

                            @else

                                <p class="text-sm text-gray-500">
                                    Event telah selesai.
                                </p>

                            @endif

                        </div>


                        {{-- Creator --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Dibuat Oleh
                            </p>

                            <p class="font-medium text-gray-900">
                                {{ $event->creator->name }}
                            </p>

                        </div>

                    </div>


                    {{-- Deskripsi --}}
                    <div class="mt-8">

                        <p class="text-sm text-gray-500 mb-2">
                            Deskripsi
                        </p>

                        <div class="bg-gray-50 rounded-lg p-4">

                            @if ($event->description)

                                <p class="text-gray-700 whitespace-pre-line">
                                    {{ $event->description }}
                                </p>

                            @else

                                <p class="text-gray-400">
                                    Tidak ada deskripsi.
                                </p>

                            @endif

                        </div>

                    </div>


                    {{-- QR Token sementara --}}
                    <div class="mt-8">

                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                QR Token
                            </p>

                            {{-- <p class="mt-1 text-sm text-gray-900 break-all">
                                {{ $event->qr_token }}
                            </p> --}}

                            <div class="mt-3">
                                <a
                                    href="{{ route('events.qr', $event) }}"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                >
                                    Lihat QR Code
                                </a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900">
            Participant Terdaftar
        </h3>

        @if ($event->participants->count())
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Identity Number
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Nama
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Email
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Institusi
                            </th>

                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($event->participants as $participant)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $participant->identity_number }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-900">
                                    {{ $participant->name }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $participant->email ?? '-' }}
                                </td>

                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ $participant->institution ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <form
                                        method="POST"
                                        action="{{ route('events.participants.remove', [$event, $participant]) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus participant ini dari event?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-sm text-red-600 hover:text-red-900"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="mt-4 text-sm text-gray-500">
                Belum ada participant yang terdaftar pada event ini.
            </p>
        @endif
    </div>
</div>

    </div>

</x-app-layout>