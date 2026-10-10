<?php

namespace App\Imports;

use App\Models\Event;
use App\Models\Participant;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParticipantImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsEmptyRows
{
    protected int $newParticipants = 0;

    protected int $existingParticipants = 0;

    protected int $attachedParticipants = 0;

    protected array $participantCache = [];
    public function __construct(
        protected Event $event
    ) {
    }

    public function model(array $row)
    {
        $identityNumber = trim($row['identity_number']);

        $participant = $this->participantCache[$identityNumber] ?? null;

        if (!$participant) {
            $participant = Participant::where(
                'identity_number',
                $identityNumber
            )->first();
        }

        if ($participant) {
            $this->existingParticipants++;
        } else {
            $participant = Participant::create([
                'identity_number' => $identityNumber,
                'name' => trim($row['name']),
                'email' => !empty($row['email'])
                    ? trim($row['email'])
                    : null,
                'phone' => !empty($row['phone'])
                    ? trim($row['phone'])
                    : null,
                'institution' => !empty($row['institution'])
                    ? trim($row['institution'])
                    : null,
            ]);

            $this->newParticipants++;
        }

        $this->participantCache[$identityNumber] = $participant;

        $changes = $this->event->participants()->syncWithoutDetaching([
            $participant->id,
        ]);

        if (!empty($changes['attached'])) {
            $this->attachedParticipants++;
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'identity_number' => [
                'required',
                'max:100',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'nullable',
                'email:rfc',
                'max:255',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:14',
            ],

            'institution' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
    
    public function getNewParticipants(): int
    {
        return $this->newParticipants;
    }

    public function getExistingParticipants(): int
    {
        return $this->existingParticipants;
    }

    public function getAttachedParticipants(): int
    {
        return $this->attachedParticipants;
    }

}