@if (session('success'))
    <div
        class="mb-4 p-4 bg-green-100 border border-green-200 text-green-800 rounded-md"
    >
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div
        class="mb-4 p-4 bg-red-100 border border-red-200 text-red-800 rounded-md"
    >
        {{ session('error') }}
    </div>
@endif

@if (session('warning'))
    <div
        class="mb-4 p-4 bg-yellow-100 border border-yellow-200 text-yellow-800 rounded-md"
    >
        {{ session('warning') }}
    </div>
@endif

@if (session('info'))
    <div
        class="mb-4 p-4 bg-blue-100 border border-blue-200 text-blue-800 rounded-md"
    >
        {{ session('info') }}
    </div>
@endif