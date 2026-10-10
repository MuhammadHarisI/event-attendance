<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Participant
        </h2>

    </x-slot>


    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    {{-- Validation Errors --}}
                    @if ($errors->any())

                        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-md">

                            <ul class="list-disc list-inside">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('participants.update', $participant) }}"
                    >

                        @csrf
                        @method('PUT')


                        {{-- Identity Number --}}
                        <div class="mb-4">

                            <label
                                for="identity_number"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Identity Number
                            </label>

                            <input
                                type="text"
                                id="identity_number"
                                name="identity_number"
                                value="{{ old('identity_number', $participant->identity_number) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        {{-- Name --}}
                        <div class="mb-4">

                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $participant->name) }}"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        {{-- Email --}}
                        <div class="mb-4">

                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $participant->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        {{-- Phone --}}
                        <div class="mb-4">

                            <label
                                for="phone"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Telepon
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $participant->phone) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        {{-- Institution --}}
                        <div class="mb-6">

                            <label
                                for="institution"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Institusi
                            </label>

                            <input
                                type="text"
                                id="institution"
                                name="institution"
                                value="{{ old('institution', $participant->institution) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        {{-- Buttons --}}
                        <div class="flex items-center gap-3">

                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                            >
                                Simpan Perubahan
                            </button>

                            <a
                                href="{{ route('participants.show', $participant) }}"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300"
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