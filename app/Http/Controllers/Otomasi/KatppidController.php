<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Katppid;
use Illuminate\Http\Request;

class KatppidController extends Controller
{
    /**
     * Menampilkan daftar kategori PPID
     */
    public function index()
    {
        $kategoriPpid = Katppid::latest()->paginate(10);

        return view('administrator.katppid.index', compact('kategoriPpid'));
    }


    /**
     * Form tambah kategori PPID
     */
    public function create()
    {
        return view('administrator.katppid.create');
    }


    /**
     * Menyimpan data kategori PPID
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nm_ppid' => [
                'required',
                'string',
                'max:255',
                'unique:katppid,nm_ppid'
            ],
        ], [
            'nm_ppid.required' => 'Nama kategori PPID wajib diisi.',
            'nm_ppid.unique' => 'Nama kategori PPID sudah tersedia.',
        ]);

        Katppid::create([
            'nm_ppid' => $validated['nm_ppid'],
        ]);

        return redirect()
            ->route('panel.katppid.index')
            ->with('success', 'Kategori PPID berhasil ditambahkan.');
    }


    /**
     * Detail data
     */
    public function show(Katppid $katppid)
    {
        return view('administrator.katppid.show', compact('katppid'));
    }


    /**
     * Form edit
     */
    public function edit(Katppid $katppid)
    {
        return view('administrator.katppid.edit', compact('katppid'));
    }


    /**
     * Update data
     */
    public function update(Request $request, Katppid $katppid)
    {
        $validated = $request->validate([
            'nm_ppid' => [
                'required',
                'string',
                'max:255',
                'unique:katppid,nm_ppid,' . $katppid->id
            ],
        ]);

        $katppid->update([
            'nm_ppid' => $validated['nm_ppid'],
        ]);

        return redirect()
            ->route('panel.katppid.index')
            ->with('success', 'Nama kategori PPID berhasil diperbarui.');
    }


    /**
     * Hapus data
     */
    public function destroy(Katppid $katppid)
    {
        $katppid->delete();

        return redirect()
            ->route('panel.katppid.index')
            ->with('success', 'Nama kategori PPID berhasil dihapus.');
    }
}
