<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Imports\ParticipantImport;
use App\Models\Participant;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->user()->role === 'admin') {
            $query->whereHas('admins', function ($adminQuery) use ($request) {
                $adminQuery->where('users.id', $request->user()->id);
            });
        }

        $query->withCount([
            'participants',
            'attendances',
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(10)->withQueryString();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
        ]);

        Event::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(6),
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'qr_token' => Str::random(32),
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event)
    {
        $event->load('participants');

        return view('events.show', compact('event'));
    }
    public function admins(Event $event)
    {
        $admins = \App\Models\User::where('role', 'admin')
            ->orderBy('name')
            ->get();

        $event->load('admins');

        $assignedAdminIds = $event->admins
            ->pluck('id')
            ->toArray();

        return view('events.admins', compact(
            'event',
            'admins',
            'assignedAdminIds'
        ));
    }

    public function assignAdmin(Request $request, Event $event)
    {
        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
            ],
        ]);

        $admin = \App\Models\User::findOrFail(
            $validated['user_id']
        );

        if ($admin->role !== 'admin') {
            abort(403);
        }

        $event->admins()->syncWithoutDetaching([
            $admin->id,
        ]);

        return back()->with(
            'success',
            'Admin berhasil ditugaskan ke event.'
        );
    }

    public function removeAdmin(Event $event, \App\Models\User $user)
    {
        if ($user->role !== 'admin') {
            abort(404);
        }

        $event->admins()->detach($user->id);

        return back()->with(
            'success',
            'Admin berhasil dilepas dari event.'
        );
    }

    public function qr(Event $event)
    {
        return view('events.qr', compact('event'));
    }

    public function participants(Event $event)
    {
        $event->load('participants');

        $participants = Participant::whereNotIn(
            'id',
            $event->participants->pluck('id')
        )
            ->orderBy('name')
            ->get();

        return view('events.participants', compact(
            'event',
            'participants'
        ));
    }

    public function addParticipant(Request $request, Event $event)
    {
        $validated = $request->validate([
            'participant_id' => ['required', 'exists:participants,id'],
        ]);

        $event->participants()->syncWithoutDetaching([
            $validated['participant_id'],
        ]);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Participant berhasil ditambahkan ke event.');
    }

    public function importParticipants(Request $request, Event $event)
    {
       $request->validate(
        [
            'file' => [
                'required',
                'file',
                'max:5120',
                'extensions:xlsx,xls,csv',
            ],
        ],
        [
            'file.required' => 'Silakan pilih file yang akan di-import.',
            'file.file' => 'File yang dipilih tidak valid.',
            'file.max' => 'Ukuran file maksimal adalah 5 MB.',
            'file.extensions' => 'Format file harus XLSX, XLS, atau CSV.',
        ]
    );

        $headings = (new HeadingRowImport)->toArray(
            $request->file('file')
        );

        $headers = $headings[0][0] ?? [];

        $requiredHeaders = [
            'identity_number',
            'name',
            'email',
            'phone',
            'institution',
        ];

        $missingHeaders = array_diff(
            $requiredHeaders,
            $headers
        );

        if (!empty($missingHeaders)) {
            return back()->with(
                'import_header_errors',
                $missingHeaders
            );
        }

        $import = new ParticipantImport($event);

        try {
            Excel::import(
                $import,
                $request->file('file')
            );
        } catch (ValidationException $e) {
            $failures = $e->failures();

            return back()->with(
                'import_errors',
                $failures
            );
        }

        $new = $import->getNewParticipants();
        $existing = $import->getExistingParticipants();
        $attached = $import->getAttachedParticipants();

        if ($new === 0 && $existing === 0 && $attached === 0) {
            return back()->with(
                'import_empty',
                'File berhasil dibaca, tetapi tidak terdapat data participant yang dapat di-import.'
            );
        }

        return back()->with(
            'import_summary',
            [
                'new' => $new,
                'existing' => $existing,
                'attached' => $attached,
            ]
        );
    }

    public function removeParticipant(Event $event, Participant $participant)
    {
        if (!$event->participants()->whereKey($participant->id)->exists()) {
            abort(404);
        }

        $event->participants()->detach($participant->id);

        return back()->with(
            'success',
            'Participant berhasil dihapus dari event.'
        );
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'status' => ['required', 'in:draft,active,finished'],
        ]);

        $currentStatus = $event->status;
        $newStatus = $validated['status'];

        if ($currentStatus === 'finished' && $newStatus !== 'finished') {
            return back()
                ->withErrors([
                    'status' => 'Event yang sudah selesai tidak dapat diaktifkan kembali.',
                ])
                ->withInput();
        }

        if ($currentStatus === 'draft' && $newStatus === 'finished') {
            return back()
                ->withErrors([
                    'status' => 'Event Draft harus diaktifkan terlebih dahulu.',
                ])
                ->withInput();
        }

        $event->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],
            'status' => $newStatus,
        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function activate(Event $event)
    {
        if ($event->status !== 'draft') {
            return back()
                ->withErrors([
                    'status' => 'Hanya event Draft yang dapat diaktifkan.',
                ]);
        }

        $event->update([
            'status' => 'active',
        ]);

        return back()->with('success', 'Event berhasil diaktifkan.');
    }

    public function finish(Event $event)
    {
        if ($event->status !== 'active') {
            return back()
                ->withErrors([
                    'status' => 'Hanya event Active yang dapat diselesaikan.',
                ]);
        }

        $event->update([
            'status' => 'finished',
        ]);

        return back()->with('success', 'Event berhasil diselesaikan.');
    }
}