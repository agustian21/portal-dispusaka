<?php

namespace App\Http\Controllers\otomasi;

use App\Http\Controllers\Controller;
use App\Models\Tugasppid;
use Illuminate\Http\Request;

class TugasppidController extends Controller
{
    public function index()
    {
        $data = Tugasppid::first();

        return view('administrator.profilppid.tugasppid', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tugasutama' => ['required', 'string'],
            'tugaspelaksana' => ['required', 'string'],
        ], [
            'tugasutama.required' => 'Tugas dan Tanggung jawab PPID Utama wajib diisi.',
            'tugaspelaksana.required' => 'Tugas dan Tanggung jawab PPID Pelaksana wajib diisi.',
        ]);

        // Karena visi dan misi hanya menggunakan satu record
        if (Tugasppid::exists()) {
            return redirect()
                ->route('panel.tugasppid.index')
                ->with('error', 'Data Tugas dan Tanggung jawab PPID sudah tersedia.');
        }

        Tugasppid::create([
            'tugasutama' => $request->tugasutama,
            'tugaspelaksana' => $request->tugaspelaksana,
            'created_by' => $request->user()->name,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.tugasppid.index')
            ->with('success', 'Tugas dan Tanggung jawab PPID berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tugasutama' => ['required', 'string'],
            'tugaspelaksana' => ['required', 'string'],
        ], [
            'tugasutama.required' => 'Tugas dan Tanggung jawab PPID Utama wajib diisi.',
            'tugaspelaksana.required' => 'Tugas dan Tanggung jawab PPID Pelaksana wajib diisi.',
        ]);

        $data = Tugasppid::findOrFail($id);

        $data->update([
            'tugasutama' => $request->tugasutama,
            'tugaspelaksana' => $request->tugaspelaksana,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.tugasppid.index')
            ->with('success', 'Tugas dan Tanggung jawab PPID berhasil diperbarui.');
    }
}
