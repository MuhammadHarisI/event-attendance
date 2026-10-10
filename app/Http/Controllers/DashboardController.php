<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function superUser()
    {
        $totalEvents = Event::count();

        $draftEvents = Event::where('status', 'draft')->count();

        $activeEvents = Event::where('status', 'active')->count();

        $finishedEvents = Event::where('status', 'finished')->count();

        $totalParticipants = \App\Models\Participant::count();

        $totalAttendances = \App\Models\Attendance::count();

        $attendancePercentage = $totalParticipants > 0
            ? round(($totalAttendances / $totalParticipants) * 100, 1)
            : 0;

        $latestEvents = Event::latest()
            ->take(5)
            ->get();

        $activeEventsList = Event::where('status', 'active')
            ->withCount([
                'participants',
                'attendances',
            ])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.super', compact(
            'totalEvents',
            'draftEvents',
            'activeEvents',
            'finishedEvents',
            'totalParticipants',
            'totalAttendances',
            'attendancePercentage',
            'latestEvents',
            'activeEventsList'
        ));
    }

    public function admin()
    {
        $events = Event::whereHas('admins', function ($query) {
            $query->where('users.id', auth()->id());
        })
            ->withCount([
                'participants',
                'attendances',
            ])
            ->latest()
            ->get();

        return view('dashboard.admin', compact('events'));
    }
}