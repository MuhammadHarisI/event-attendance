<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::latest()->paginate(10);

        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        return view('participants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'identity_number' => [
                'required',
                'string',
                'max:100',
                'unique:participants,identity_number',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
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
        ]);

        Participant::create($validated);

        return redirect()
            ->route('participants.index')
            ->with('success', 'Participant berhasil ditambahkan.');
    }

    public function show(Participant $participant)
    {
        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'identity_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('participants', 'identity_number')
                    ->ignore($participant->id),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
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
        ]);

        $participant->update($validated);

        return redirect()
            ->route('participants.show', $participant)
            ->with('success', 'Participant berhasil diperbarui.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()
            ->route('participants.index')
            ->with('success', 'Participant berhasil dihapus.');
    }
}