<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Databidang;
use App\Models\Namabidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DatabidangController extends Controller
{
    /**
     * Menampilkan seluruh Data Bidang.
     */
    public function index()
    {
        $databidang = Databidang::with('namabidang')
            ->orderBy('id', 'desc')
            ->get();

        return view('administrator.databidang.index', compact('databidang'));
    }


    /**
     * Menampilkan halaman tambah Data Bidang.
     */
    public function create()
    {
        $namabidang = Namabidang::orderBy('id')->get();

        return view('administrator.databidang.create', compact('namabidang'));
    }


    /**
     * Menyimpan Data Bidang baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'namabidang_id' => [
                'required',
                Rule::exists((new Namabidang)->getTable(), 'id'),
            ],

            'file' => [
                'required',
                'url',
                'max:2048',
                function ($attribute, $value, $fail) {
                    $host = strtolower(parse_url($value, PHP_URL_HOST) ?? '');

                    if (!in_array($host, [
                        'drive.google.com',
                        'docs.google.com',
                    ])) {
                        $fail('Link harus berasal dari Google Drive.');
                    }
                },
            ],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.string'   => 'Judul harus berupa teks.',
            'judul.max'      => 'Judul maksimal 255 karakter.',

            'namabidang_id.required' => 'Kategori bidang wajib dipilih.',
            'namabidang_id.exists'   => 'Kategori bidang tidak ditemukan.',

            'file.required' => 'Link Google Drive wajib diisi.',
            'file.url'      => 'Link Google Drive tidak valid.',
            'file.max'      => 'Link Google Drive maksimal 2048 karakter.',
        ]);

        Databidang::create([
            'judul'         => $validated['judul'],
            'namabidang_id' => $validated['namabidang_id'],
            'file'          => $validated['file'],
            'status_id'     => 1,
            'created_by'    => Auth::user()->name,
            'updated_by'    => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.databidang.index')
            ->with('success', 'Data Bidang berhasil ditambahkan.');
    }


    /**
     * Menampilkan detail Data Bidang.
     */
    public function show($id)
    {
        $databidang = Databidang::with('namabidang')
            ->findOrFail($id);

        return view('administrator.databidang.show', compact('databidang'));
    }


    /**
     * Menampilkan halaman edit Data Bidang.
     */
    public function edit($id)
    {
        $databidang = Databidang::findOrFail($id);

        $namabidang = Namabidang::orderBy('id')->get();

        return view('administrator.databidang.edit', compact(
            'databidang',
            'namabidang'
        ));
    }


    /**
     * Memperbarui Data Bidang.
     */
    public function update(Request $request, $id)
    {
        $databidang = Databidang::findOrFail($id);

        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'namabidang_id' => [
                'required',
                Rule::exists((new Namabidang)->getTable(), 'id'),
            ],

            'file' => [
                'required',
                'url',
                'max:2048',
                function ($attribute, $value, $fail) {
                    $host = strtolower(parse_url($value, PHP_URL_HOST) ?? '');

                    if (!in_array($host, [
                        'drive.google.com',
                        'docs.google.com',
                    ])) {
                        $fail('Link harus berasal dari Google Drive.');
                    }
                },
            ],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'judul.string'   => 'Judul harus berupa teks.',
            'judul.max'      => 'Judul maksimal 255 karakter.',

            'namabidang_id.required' => 'Kategori bidang wajib dipilih.',
            'namabidang_id.exists'   => 'Kategori bidang tidak ditemukan.',

            'file.required' => 'Link Google Drive wajib diisi.',
            'file.url'      => 'Link Google Drive tidak valid.',
            'file.max'      => 'Link Google Drive maksimal 2048 karakter.',
        ]);

        $databidang->update([
            'judul'         => $validated['judul'],
            'namabidang_id' => $validated['namabidang_id'],
            'file'          => $validated['file'],
            'updated_by'    => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.databidang.index')
            ->with('success', 'Data Bidang berhasil diperbarui.');
    }


    /**
     * Menghapus Data Bidang.
     */
    public function destroy($id)
    {
        $databidang = Databidang::findOrFail($id);

        $databidang->delete();

        return redirect()
            ->route('panel.databidang.index')
            ->with('success', 'Data Bidang berhasil dihapus.');
    }


    /**
     * Mengubah status aktif/nonaktif Data Bidang.
     */
    public function status($id)
    {
        $databidang = Databidang::findOrFail($id);

        $databidang->update([
            'status_id'  => $databidang->status_id == 1 ? 0 : 1,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.databidang.index')
            ->with('success', 'Status Data Bidang berhasil diubah.');
    }
}
