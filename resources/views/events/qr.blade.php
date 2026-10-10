<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR Code Event
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Header Event --}}
                    <div class="text-center">

                        <h3 class="text-2xl font-bold text-gray-900">
                            {{ $event->name }}
                        </h3>

                        <div class="mt-3">
                            @if ($event->status === 'active')

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                                    Absensi Aktif
                                </span>

                            @elseif ($event->status === 'draft')

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    Draft
                                </span>

                            @elseif ($event->status === 'finished')

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Event Selesai
                                </span>

                            @endif
                        </div>

                        <p class="mt-4 text-gray-600">
                            Scan QR Code menggunakan kamera smartphone untuk melakukan absensi.
                        </p>

                    </div>

                    {{-- QR Code --}}
                    @php
                        $attendanceUrl = route('attendance.form', $event->qr_token);
                        $qrCodeSvg = QrCode::size(300)->generate($attendanceUrl);
                    @endphp

                    <div
                        id="printable-qr"
                        class="mt-8 flex justify-center"
                    >
                        <div class="p-6 bg-white border-2 border-gray-200 rounded-xl shadow-sm text-center">

                            <h4 class="text-xl font-bold text-gray-900 mb-4">
                                {{ $event->name }}
                            </h4>

                            {!! $qrCodeSvg !!}

                            <p class="mt-4 text-sm text-gray-600">
                                Scan QR Code untuk melakukan absensi
                            </p>

                        </div>
                    </div>

                    {{-- Link Absensi --}}
                    <div class="mt-6 max-w-xl mx-auto">

                        <p class="text-sm font-medium text-gray-700 text-center">
                            Link Absensi
                        </p>

                        <div class="mt-2 flex flex-col sm:flex-row items-stretch gap-2">

                            <input
                                id="attendance-url"
                                type="text"
                                value="{{ $attendanceUrl }}"
                                readonly
                                class="w-full flex-1 border-gray-300 rounded-md shadow-sm bg-gray-50 text-sm text-gray-600"
                            >

                            <button
                                type="button"
                                onclick="copyAttendanceUrl()"
                                id="copy-attendance-button"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 whitespace-nowrap"
                            >
                                Salin Link
                            </button>

                        </div>

                        <p class="mt-2 text-xs text-gray-500 text-center">
                            Link ini dapat dibagikan langsung kepada peserta.
                        </p>

                    </div>

                    <div class="mt-4 flex justify-center gap-3">

                        <button
                            type="button"
                            onclick="downloadQrPng()"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            Download
                        </button>
                        <button
                            type="button"
                            onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        >
                            Print QR
                        </button>

                    </div>

                    {{-- Status QR --}}
                    @if ($event->status === 'active')

                        <div class="mt-6 text-center">

                            <p class="text-sm font-medium text-green-600">
                                ✓ QR Code dapat digunakan
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Peserta dapat melakukan absensi sekarang.
                            </p>

                        </div>

                    @elseif ($event->status === 'finished')

                        <div class="mt-6 text-center">

                            <p class="text-sm font-medium text-red-600">
                                QR Code tidak aktif
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Event telah selesai dan absensi tidak dapat dilakukan.
                            </p>

                        </div>

                    @elseif ($event->status === 'draft')

                        <div class="mt-6 text-center">

                            <p class="text-sm font-medium text-yellow-600">
                                QR Code belum aktif
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Aktifkan event terlebih dahulu untuk menerima absensi.
                            </p>

                        </div>

                    @endif

                    {{-- Navigasi --}}
                    <div class="mt-8 flex justify-center">

                        <a
                            href="{{ route('events.show', $event) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        >
                            Kembali ke Event
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <style>
        @media print {

            body * {
                visibility: hidden;
            }

            #printable-qr,
            #printable-qr * {
                visibility: visible;
            }

            #printable-qr {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: auto;
            }

            #printable-qr > div {
                border: none !important;
                box-shadow: none !important;
            }

            @page {
                margin: 0;
            }
        }
    </style>
    <script>
        function downloadQrPng() {
            const svg = document.querySelector('#printable-qr svg');

            if (!svg) {
                alert('QR Code tidak ditemukan.');
                return;
            }

            const serializer = new XMLSerializer();
            const svgString = serializer.serializeToString(svg);

            const svgBlob = new Blob(
                [svgString],
                { type: 'image/svg+xml;charset=utf-8' }
            );

            const url = URL.createObjectURL(svgBlob);
            const image = new Image();

            image.onload = function () {
                const canvas = document.createElement('canvas');

                const padding = 40;
                const size = Math.max(image.width, image.height);

                canvas.width = size + padding;
                canvas.height = size + padding;

                const context = canvas.getContext('2d');

                context.fillStyle = '#ffffff';
                context.fillRect(
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );

                context.drawImage(
                    image,
                    padding / 2,
                    padding / 2,
                    size,
                    size
                );

                URL.revokeObjectURL(url);

                const link = document.createElement('a');

                link.download =
                    'qr-{{ \Illuminate\Support\Str::slug($event->name) }}.png';

                link.href = canvas.toDataURL('image/png');

                link.click();
            };

            image.onerror = function () {
                URL.revokeObjectURL(url);
                alert('Gagal membuat QR Code PNG.');
            };

            image.src = url;
        }
        function copyAttendanceUrl() {
            const input = document.getElementById('attendance-url');
            const button = document.getElementById('copy-attendance-button');

            navigator.clipboard.writeText(input.value)
                .then(function () {

                    const originalText = button.innerText;

                    button.innerText = 'Link Tersalin ✓';

                    setTimeout(function () {
                        button.innerText = originalText;
                    }, 2000);

                })
                .catch(function () {
                    alert('Gagal menyalin link.');
                });
        }
    </script>
</x-app-layout>