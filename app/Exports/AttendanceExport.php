<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function collection()
    {
        $participants = $this->event
            ->participants()
            ->with([
                'attendances' => function ($query) {
                    $query->where('event_id', $this->event->id);
                }
            ])
            ->orderBy('name')
            ->get();

        return $participants->map(function ($participant) {

            $attendance = $participant->attendances->first();

            return [
                'identity_number' => $participant->identity_number,
                'name' => $participant->name,
                'status' => $attendance ? 'Hadir' : 'Belum Hadir',
                'checked_in_at' => $attendance
                    ? $attendance->checked_in_at->format('d-m-Y H:i:s')
                    : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Identity Number',
            'Nama',
            'Status',
            'Waktu Absen',
        ];
    }
}