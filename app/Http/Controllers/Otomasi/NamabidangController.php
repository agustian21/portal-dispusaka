<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Namabidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NamabidangController extends Controller
{
    /**
     * Menampilkan daftar nama bidang
     */
    public function index()
    {
        $namabidangs = Namabidang::latest()->paginate(10);

        return view('administrator.namabidang.index', compact('namabidangs'));
    }


    /**
     * Form tambah nama bidang
     */
    public function create()
    {
        return view('administrator.namabidang.create');
    }


    /**
     * Menyimpan data nama bidang
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bidang' => [
                'required',
                'string',
                'max:255',
                'unique:namabidangs,nama_bidang'
            ],
            'deskripsi' => [
                'required',
                'string'
            ],
            'status_id' => [
                'required',
                'integer'
            ],
        ], [
            'nama_bidang.required' => 'Nama bidang wajib diisi.',
            'nama_bidang.unique' => 'Nama bidang sudah tersedia.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'status_id.required' => 'Status wajib dipilih.',
        ]);


        Namabidang::create([
            'nama_bidang' => $validated['nama_bidang'],
            'deskripsi' => $validated['deskripsi'],
            'status_id' => $validated['status_id'],
            'created_by' => Auth::user()->name,
            'updated_by' => Auth::user()->name,
        ]);


        return redirect()
            ->route('panel.namabidang.index')
            ->with('success', 'Nama bidang berhasil ditambahkan.');
    }


    /**
     * Detail data
     */
    public function show(Namabidang $namabidang)
    {
        return view(
            'administrator.namabidang.show',
            compact('namabidang')
        );
    }


    /**
     * Form edit
     */
    public function edit(Namabidang $namabidang)
    {
        return view(
            'administrator.namabidang.edit',
            compact('namabidang')
        );
    }


    /**
     * Update data
     */
    public function update(Request $request, Namabidang $namabidang)
    {
        $validated = $request->validate([
            'nama_bidang' => [
                'required',
                'string',
                'max:255',
                'unique:namabidangs,nama_bidang,' . $namabidang->id
            ],
            'deskripsi' => [
                'required',
                'string'
            ],
            'status_id' => [
                'required',
                'integer'
            ],
        ]);


        $namabidang->update([
            'nama_bidang' => $validated['nama_bidang'],
            'deskripsi' => $validated['deskripsi'],
            'status_id' => $validated['status_id'],
            'updated_by' => Auth::user()->name,
        ]);


        return redirect()
            ->route('panel.namabidang.index')
            ->with('success', 'Nama bidang berhasil diperbarui.');
    }


    /**
     * Hapus data
     */
    public function destroy(Namabidang $namabidang)
    {
        $namabidang->delete();


        return redirect()
            ->route('panel.namabidang.index')
            ->with('success', 'Nama bidang berhasil dihapus.');
    }
}
