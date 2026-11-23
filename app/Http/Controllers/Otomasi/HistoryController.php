<?php

namespace App\Http\Controllers\otomasi;

use App\Http\Controllers\Controller;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $data = History::first();

        return view('administrator.instansi.history', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sejarah_instansi' => ['required', 'string'],
        ], [
            'sejarah_instansi.required' => 'Sejarah Instansi wajib diisi.',
        ]);

        // Data alamat hanya menggunakan satu record
        if (History::exists()) {
            return redirect()
                ->route('panel.sejarah-dinas.index')
                ->with('error', 'Data sejarah instansi sudah tersedia.');
        }

        History::create([
            'sejarah_instansi'  => $request->sejarah_instansi,
            'created_by'        => $request->user()->name,
            'updated_by'        => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.sejarah-dinas.index')
            ->with('success', 'Data sejarah instansi berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sejarah_instansi' => ['required', 'string'],
        ], [
            'sejarah_instansi.required' => 'Sejarah Instansi wajib diisi.',
        ]);

        $data = History::findOrFail($id);

        $data->update([
            'sejarah_instansi'  => $request->sejarah_instansi,
            'updated_by'        => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.sejarah-dinas.index')
            ->with('success', 'Data sejarah instansi berhasil diperbarui.');
    }
}
