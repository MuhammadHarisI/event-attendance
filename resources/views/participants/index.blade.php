<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Participant Management
            </h2>

            <a
                href="{{ route('participants.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
            >
                + Tambah Participant
            </a>

        </div>

    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))

                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Participant Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead>

                                <tr>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Identity Number
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Nama
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Email
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Telepon
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Institusi
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-200">

                                @forelse ($participants as $participant)

                                    <tr>

                                        <td class="px-4 py-3">
                                            {{ $participant->identity_number }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $participant->name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $participant->email ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $participant->phone ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $participant->institution ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3">

                                            <div class="flex gap-3">

                                                <a
                                                    href="{{ route('participants.show', $participant) }}"
                                                    class="text-blue-600 hover:text-blue-800"
                                                >
                                                    Detail
                                                </a>

                                                <a
                                                    href="{{ route('participants.edit', $participant) }}"
                                                    class="text-yellow-600 hover:text-yellow-800"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    method="POST"
                                                    action="{{ route('participants.destroy', $participant) }}"
                                                    onsubmit="return confirm('Yakin ingin menghapus participant ini?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:text-red-800"
                                                    >
                                                        Hapus
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="6"
                                            class="px-4 py-6 text-center text-gray-500"
                                        >
                                            Belum ada participant.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- Pagination --}}
                    <div class="mt-6">

                        {{ $participants->links() }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>