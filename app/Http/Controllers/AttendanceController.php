<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function form(string $qr_token)
    {
        $event = Event::where('qr_token', $qr_token)->firstOrFail();

        if ($event->status !== 'active') {
            abort(403, 'Event tidak sedang aktif.');
        }

        return view('attendance.form', compact('event'));
    }

   public function check(Request $request, string $qr_token)
    {
        $event = Event::where('qr_token', $qr_token)->firstOrFail();

        if ($event->status !== 'active') {
            abort(403, 'Event tidak sedang aktif.');
        }

        $validated = $request->validate([
            'identity_number' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $participant = $event->participants()
            ->where(
                'identity_number',
                trim($validated['identity_number'])
            )
            ->first();

        if (!$participant) {
            return back()
                ->withErrors([
                    'identity_number' => 'Identity Number tidak ditemukan.',
                ])
                ->withInput();
        }

        $alreadyAttended = $event->attendances()
            ->where('participant_id', $participant->id)
            ->first();

        if ($alreadyAttended) {
            return back()
                ->withErrors([
                    'identity_number' => 'Kamu sudah melakukan absensi pada event ini.',
                ])
                ->withInput();
        }

        $attendance = Attendance::create([
            'event_id' => $event->id,
            'participant_id' => $participant->id,
            'checked_in_at' => now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return view('attendance.success', compact(
            'event',
            'participant',
            'attendance'
        ));
    }
    public function index(Request $request, Event $event)
    {
       $event->load([
            'attendances',
        ]);

        $participantsQuery = $event->participants();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $participantsQuery->where(function ($query) use ($search) {
                $query->where('identity_number', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $status = $request->input('status', 'all');

        if ($status === 'attended') {
            $participantsQuery->whereHas('attendances', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            });
        }

        if ($status === 'not_attended') {
            $participantsQuery->whereDoesntHave('attendances', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            });
        }

        $participants = $participantsQuery
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $attendances = $event->attendances->keyBy('participant_id');

        $totalParticipants = $event->participants->count();

        $totalAttended = $event->attendances->count();

        $totalNotAttended = $totalParticipants - $totalAttended;

        $attendancePercentage = $totalParticipants > 0
        ? round(($totalAttended / $totalParticipants) * 100, 1)
        : 0;

        return view(
            'attendance.index',
            compact(
                'event',
                'participants',
                'attendances',
                'totalParticipants',
                'totalAttended',
                'totalNotAttended',
                'attendancePercentage',
                'status'
            )
        );
    }
       public function export(Event $event)
    {
        return Excel::download(
            new AttendanceExport($event),
            'attendance-' . $event->id . '.xlsx'
        );
    }
}