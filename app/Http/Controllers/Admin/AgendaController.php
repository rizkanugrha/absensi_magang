<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    /**
     * Menampilkan daftar semua Agenda.
     */
    public function index()
    {
        $agendas = Agenda::latest()->paginate(10);
        return view('admin.agenda.index', compact('agendas'));
    }

    /**
     * Menampilkan form untuk membuat Agenda baru.
     */
    public function create()
    {
        return view('admin.agenda.form');
    }

    /**
     * Menyimpan Agenda baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        $validated['user_id'] = Auth::id(); // Mencatat admin yang membuat agenda

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit Agenda.
     */
    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.form', compact('agenda'));
    }

    /**
     * Memperbarui Agenda di database.
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Menghapus Agenda dari database.
     */
    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}