<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Ppid;
use App\Models\Katppid;
use App\Models\Katinformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PpidController extends Controller
{
    /**
     * Menampilkan seluruh data PPID.
     */
    public function index()
    {
        $ppid = Ppid::with([
            'katppid',
            'katinformasi',
        ])
            ->orderBy('id', 'desc')
            ->orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('administrator.ppid.index', compact('ppid'));
    }


    /**
     * Menampilkan halaman tambah data PPID.
     */
    public function create()
    {
        $katppid = Katppid::orderBy('id')->get();
        $katinformasi = Katinformasi::orderBy('id')->get();

        return view('administrator.ppid.create', compact(
            'katppid',
            'katinformasi'
        ));
    }


    /**
     * Menyimpan data PPID baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'katppid_id' => [
                'required',
                Rule::exists((new Katppid)->getTable(), 'id'),
            ],

            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'katinformasi_id' => [
                'required',
                Rule::exists((new Katinformasi)->getTable(), 'id'),
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

            'tahun' => [
                'required',
                'string',
                'max:11',
            ],
        ], [
            'katppid_id.required' => 'Informasi publik wajib dipilih.',
            'katppid_id.exists'   => 'Informasi publik tidak ditemukan.',

            'judul.required' => 'Judul wajib diisi.',
            'judul.string'   => 'Judul harus berupa teks.',
            'judul.max'      => 'Judul maksimal 255 karakter.',

            'katinformasi_id.required' => 'Kategori publik wajib dipilih.',
            'katinformasi_id.exists'   => 'Kategori publik tidak ditemukan.',

            'file.required' => 'Link Google Drive wajib diisi.',
            'file.url'      => 'Link Google Drive tidak valid.',
            'file.max'      => 'Link Google Drive maksimal 2048 karakter.',

            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.string'  => 'Tahun harus berupa angka.',
            'tahun.max'      => 'Tahun maksimal 11 karakter.',
        ]);

        Ppid::create([
            'katppid_id'      => $validated['katppid_id'],
            'judul'           => $validated['judul'],
            'katinformasi_id' => $validated['katinformasi_id'],
            'file'            => $validated['file'],
            'tahun'           => $validated['tahun'],
            'status_id'       => 1,
            'created_by'      => Auth::user()->name,
            'updated_by'      => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.ppid.index')
            ->with('success', 'Data PPID berhasil ditambahkan.');
    }


    /**
     * Menampilkan detail PPID.
     */
    public function show($id)
    {
        $ppid = Ppid::with([
            'katppid',
            'katinformasi',
        ])->findOrFail($id);

        return view('administrator.ppid.show', compact('ppid'));
    }


    /**
     * Menampilkan halaman edit PPID.
     */
    public function edit($id)
    {
        $ppid = Ppid::findOrFail($id);

        $katppid = Katppid::orderBy('id')->get();
        $katinformasi = Katinformasi::orderBy('id')->get();

        return view('administrator.ppid.edit', compact(
            'ppid',
            'katppid',
            'katinformasi'
        ));
    }


    /**
     * Memperbarui data PPID.
     */
    public function update(Request $request, $id)
    {
        $ppid = Ppid::findOrFail($id);

        $validated = $request->validate([
            'katppid_id' => [
                'required',
                Rule::exists((new Katppid)->getTable(), 'id'),
            ],

            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'katinformasi_id' => [
                'required',
                Rule::exists((new Katinformasi)->getTable(), 'id'),
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

            'tahun' => [
                'required',
                'string',
                'max:11',
            ],

        ], [
            'katppid_id.required' => 'Informasi publik wajib dipilih.',
            'katppid_id.exists'   => 'Informasi publik tidak ditemukan.',

            'judul.required' => 'Judul wajib diisi.',
            'judul.string'   => 'Judul harus berupa teks.',
            'judul.max'      => 'Judul maksimal 255 karakter.',

            'katinformasi_id.required' => 'Kategori publik wajib dipilih.',
            'katinformasi_id.exists'   => 'Kategori publik tidak ditemukan.',

            'file.required' => 'Link Google Drive wajib diisi.',
            'file.url'      => 'Link Google Drive tidak valid.',
            'file.max'      => 'Link Google Drive maksimal 2048 karakter.',

            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.string'  => 'Tahun harus berupa angka.',
            'tahun.max'      => 'Tahun tidak valid.',
        ]);

        $ppid->update([
            'katppid_id'      => $validated['katppid_id'],
            'judul'           => $validated['judul'],
            'katinformasi_id' => $validated['katinformasi_id'],
            'file'            => $validated['file'],
            'tahun'           => $validated['tahun'],
            'updated_by'      => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.ppid.index')
            ->with('success', 'Data PPID berhasil diperbarui.');
    }


    /**
     * Menghapus data PPID.
     */
    public function destroy($id)
    {
        $ppid = Ppid::findOrFail($id);

        $ppid->delete();

        return redirect()
            ->route('panel.ppid.index')
            ->with('success', 'Data PPID berhasil dihapus.');
    }


    /**
     * Mengubah status aktif/nonaktif PPID.
     */
    public function status($id)
    {
        $ppid = Ppid::findOrFail($id);

        $ppid->update([
            'status_id'  => $ppid->status_id == 1 ? 0 : 1,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.ppid.index')
            ->with('success', 'Status PPID berhasil diubah.');
    }
}
