<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Kelola Admin Event
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $event->name }}
                </p>
            </div>

            <a
                href="{{ route('events.show', $event) }}"
                class="text-gray-600 hover:underline"
            >
                Kembali ke Event
            </a>

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

            {{-- Assign Admin --}}
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Tambah Admin
                    </h3>

                    <form
                        method="POST"
                        action="{{ route('events.admins.assign', $event) }}"
                        class="flex flex-col sm:flex-row gap-3"
                    >
                        @csrf

                        @php
                            $availableAdmins = $admins->whereNotIn('id', $assignedAdminIds);
                        @endphp

                        @if ($availableAdmins->count())

                            <select
                                name="user_id"
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                                <option value="">
                                    Pilih Admin
                                </option>

                                @foreach ($availableAdmins as $admin)

                                    <option value="{{ $admin->id }}">
                                        {{ $admin->name }} — {{ $admin->email }}
                                    </option>

                                @endforeach

                            </select>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                            >
                                Assign Admin
                            </button>

                        @else

                            <div class="w-full p-3 bg-gray-50 text-gray-500 rounded-md">
                                Semua admin sudah ditugaskan ke event ini.
                            </div>

                        @endif

                    </form>

                </div>

            </div>

            {{-- Assigned Admins --}}
            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Admin yang Ditugaskan
                    </h3>

                    @if ($event->admins->count())

                        <div class="overflow-x-auto">

                            <table class="min-w-full border border-gray-200">

                                <thead class="bg-gray-100">

                                    <tr>

                                        <th class="px-4 py-3 border text-left">
                                            Nama
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Email
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($event->admins as $admin)

                                        <tr>

                                            <td class="px-4 py-3 border">
                                                {{ $admin->name }}
                                            </td>

                                            <td class="px-4 py-3 border">
                                                {{ $admin->email }}
                                            </td>

                                            <td class="px-4 py-3 border">

                                                <form
                                                    method="POST"
                                                    action="{{ route('events.admins.remove', [$event, $admin]) }}"
                                                    onsubmit="return confirm('Yakin ingin melepas admin ini dari event?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:underline"
                                                    >
                                                        Lepas
                                                    </button>

                                                </form>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center py-8 text-gray-500">
                            Belum ada admin yang ditugaskan ke event ini.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>