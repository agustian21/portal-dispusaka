<?php

namespace App\Http\Controllers\otomasi;

use App\Http\Controllers\Controller;
use App\Models\Visimisippid;
use Illuminate\Http\Request;

class VisimisippidController extends Controller
{
    public function index()
    {
        $data = Visimisippid::first();

        return view('administrator.profilppid.visimisi', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
        ], [
            'visi.required' => 'Visi PPID wajib diisi.',
            'misi.required' => 'Misi PPID wajib diisi.',
        ]);

        // Karena visi dan misi hanya menggunakan satu record
        if (Visimisippid::exists()) {
            return redirect()
                ->route('panel.visimisippid.index')
                ->with('error', 'Data visi dan misi PPID sudah tersedia.');
        }

        Visimisippid::create([
            'visi' => $request->visi,
            'misi' => $request->misi,
            'created_by' => $request->user()->name,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.visimisippid.index')
            ->with('success', 'Visi dan misi PPID berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
        ], [
            'visi.required' => 'Visi PPID wajib diisi.',
            'misi.required' => 'Misi PPID wajib diisi.',
        ]);

        $data = Visimisippid::findOrFail($id);

        $data->update([
            'visi' => $request->visi,
            'misi' => $request->misi,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.visimisippid.index')
            ->with('success', 'Visi dan misi PPID berhasil diperbarui.');
    }
}
