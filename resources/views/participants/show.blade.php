<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Participant
        </h2>

    </x-slot>


    <div class="py-6">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <div class="space-y-4">

                        {{-- Identity Number --}}
                        <div>

                            <div class="text-sm font-medium text-gray-500">
                                Identity Number
                            </div>

                            <div class="mt-1 text-gray-900">
                                {{ $participant->identity_number }}
                            </div>

                        </div>


                        {{-- Name --}}
                        <div>

                            <div class="text-sm font-medium text-gray-500">
                                Nama
                            </div>

                            <div class="mt-1 text-gray-900">
                                {{ $participant->name }}
                            </div>

                        </div>


                        {{-- Email --}}
                        <div>

                            <div class="text-sm font-medium text-gray-500">
                                Email
                            </div>

                            <div class="mt-1 text-gray-900">
                                {{ $participant->email ?? '-' }}
                            </div>

                        </div>


                        {{-- Phone --}}
                        <div>

                            <div class="text-sm font-medium text-gray-500">
                                Telepon
                            </div>

                            <div class="mt-1 text-gray-900">
                                {{ $participant->phone ?? '-' }}
                            </div>

                        </div>


                        {{-- Institution --}}
                        <div>

                            <div class="text-sm font-medium text-gray-500">
                                Institusi
                            </div>

                            <div class="mt-1 text-gray-900">
                                {{ $participant->institution ?? '-' }}
                            </div>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="mt-6 flex items-center gap-3">

                        <a
                            href="{{ route('participants.edit', $participant) }}"
                            class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                        >
                            Edit
                        </a>

                        <a
                            href="{{ route('participants.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300"
                        >
                            Kembali
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>