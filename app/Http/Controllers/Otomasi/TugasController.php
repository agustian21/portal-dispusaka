<?php

namespace App\Http\Controllers\otomasi;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index()
    {
        $data = Tugas::first();

        return view('administrator.instansi.tugas', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tugas_fungsi' => ['required', 'string'],
            'link_google' => ['nullable', 'string'],
        ], [
            'tugas_fungsi.required' => 'Tugas dan fungsi instansi wajib diisi.',
        ]);

        // Karena visi dan misi hanya menggunakan satu record
        if (Tugas::exists()) {
            return redirect()
                ->route('panel.visi-misi-instansi.index')
                ->with('error', 'Data tugas dan fungsi instansi sudah tersedia.');
        }

        Tugas::create([
            'tugas_fungsi' => $request->tugas_fungsi,
            'link_google' => $request->link_google,
            'created_by' => $request->user()->name,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.tugas-fungsi.index')
            ->with('success', 'tugas dan fungsi instansi berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tugas_fungsi' => ['required', 'string'],
            'link_google' => ['nullable', 'string'],
        ], [
            'tugas_fungsi.required' => 'Tugas dan fungsi instansi wajib diisi.',
        ]);

        $data = Tugas::findOrFail($id);

        $data->update([
            'tugas_fungsi' => $request->tugas_fungsi,
            'link_google' => $request->link_google,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.tugas-fungsi.index')
            ->with('success', 'tugas dan fungsi instansi berhasil diperbarui.');
    }
}
