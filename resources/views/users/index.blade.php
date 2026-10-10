<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <div class="flex justify-between items-center">

                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    User Management
                </h2>

                <a
                    href="{{ route('users.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                    + Tambah Admin
                </a>

            </div>

        </div>

    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Daftar Admin
                    </h3>

                    @if ($users->count())

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
                                            Role
                                        </th>

                                        <th class="px-4 py-3 border text-left">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($users as $user)

                                        <tr>

                                            <td class="px-4 py-3 border">
                                                {{ $user->name }}
                                            </td>

                                            <td class="px-4 py-3 border">
                                                {{ $user->email }}
                                            </td>

                                            <td class="px-4 py-3 border">
                                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">
                                                    Admin
                                                </span>
                                            </td>

                                            <td class="px-4 py-3 border">

                                                <div class="flex gap-3 items-center">

                                                    <a
                                                        href="{{ route('users.edit', $user) }}"
                                                        class="text-yellow-600 hover:underline"
                                                    >
                                                        Edit
                                                    </a>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('users.destroy', $user) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus admin ini?')"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="text-red-600 hover:text-red-900"
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
                            {{ $users->links() }}
                        </div>

                    @else

                        <div class="text-center py-10 text-gray-500">
                            Belum ada admin.
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>