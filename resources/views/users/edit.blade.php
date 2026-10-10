<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Admin
            </h2>

            <a
                href="{{ route('users.index') }}"
                class="text-gray-600 hover:underline"
            >
                Kembali
            </a>

        </div>

    </x-slot>

    <div class="py-12">   

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <form
                        method="POST"
                        action="{{ route('users.update', $user) }}"
                        class="space-y-6"
                    >

                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                autofocus
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Email
                            </label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            @error('email')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Password --}}
                        <div>

                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Password Baru
                            </label>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                            <p class="mt-1 text-xs text-gray-500">
                                Kosongkan jika tidak ingin mengubah password.
                                Minimal 8 karakter jika diisi.
                            </p>

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>

                            <label
                                for="password_confirmation"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Konfirmasi Password Baru
                            </label>

                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>

                        {{-- Actions --}}
                        <div class="flex justify-end gap-3">

                            <a
                                href="{{ route('users.index') }}"
                                class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                            >
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>