<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Event
            </h2>

            <a
                href="{{ route('events.show', $event) }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
            >
                Kembali
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <form
                        method="POST"
                        action="{{ route('events.update', $event) }}"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Nama Event --}}
                        <div class="mb-4">

                            <label
                                for="name"
                                class="block font-medium text-sm text-gray-700"
                            >
                                Nama Event
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $event->name) }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('name')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Deskripsi --}}
                        <div class="mb-4">

                            <label
                                for="description"
                                class="block font-medium text-sm text-gray-700"
                            >
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            >{{ old('description', $event->description) }}</textarea>

                            @error('description')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Lokasi --}}
                        <div class="mb-4">

                            <label
                                for="location"
                                class="block font-medium text-sm text-gray-700"
                            >
                                Lokasi
                            </label>

                            <input
                                type="text"
                                name="location"
                                id="location"
                                value="{{ old('location', $event->location) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('location')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Waktu Mulai --}}
                        <div class="mb-4">

                            <label
                                for="start_at"
                                class="block font-medium text-sm text-gray-700"
                            >
                                Waktu Mulai
                            </label>

                            <input
                                type="datetime-local"
                                name="start_at"
                                id="start_at"
                                value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('start_at')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Waktu Selesai --}}
                        <div class="mb-4">

                            <label
                                for="end_at"
                                class="block font-medium text-sm text-gray-700"
                            >
                                Waktu Selesai
                            </label>

                            <input
                                type="datetime-local"
                                name="end_at"
                                id="end_at"
                                value="{{ old('end_at', $event->end_at->format('Y-m-d\TH:i')) }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('end_at')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <div class="mb-4">

                            <label
                                for="status"
                                class="block font-medium text-sm text-gray-700"
                            >
                                Status Event
                            </label>

                            <select
                                name="status"
                                id="status"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            >

                                <option
                                    value="draft"
                                    {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}
                                >
                                    Draft
                                </option>

                                <option
                                    value="active"
                                    {{ old('status', $event->status) === 'active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="finished"
                                    {{ old('status', $event->status) === 'finished' ? 'selected' : '' }}
                                >
                                    Finished
                                </option>

                            </select>

                            @error('status')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Tombol --}}
                        <div class="flex items-center gap-3 mt-6">

                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                            >
                                Simpan Perubahan
                            </button>

                            <a
                                href="{{ route('events.show', $event) }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                            >
                                Batal
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>