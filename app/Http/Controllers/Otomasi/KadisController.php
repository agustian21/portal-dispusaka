<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Kadis;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KadisController extends Controller
{
    /**
     * Menampilkan seluruh data pejabat.
     */
    public function index()
    {
        $kadis = Kadis::orderBy('id', 'desc')->get();

        return view('administrator.kadis.index', compact('kadis'));
    }

    /**
     * Menampilkan form tambah pejabat.
     */
    public function create()
    {
        return view('administrator.kadis.create');
    }

    /**
     * Menyimpan data pejabat.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:3072',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'periode' => [
                'required',
                'string',
                'max:255',
            ],

        ], [
            'foto.required' => 'Foto pejabat wajib diunggah.',
            'foto.image'    => 'File yang diunggah harus berupa gambar.',
            'foto.mimes'    => 'Foto hanya boleh berformat JPG, JPEG, atau PNG.',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',

            'nama.required' => 'Nama pejabat wajib diisi.',
            'nama.string'   => 'Nama pejabat harus berupa teks.',
            'nama.max'      => 'Nama pejabat maksimal 255 karakter.',

            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string'   => 'Jabatan tidak valid.',
            'jabatan.max'      => 'Jabatan maksimal 255 karakter.',

            'periode.required' => 'Periode wajib diisi.',
            'periode.string'   => 'Periode harus berupa teks.',
            'periode.max'      => 'Periode maksimal 255 karakter.',

        ]);

        $uploadPath = public_path('uploads_files/kadis');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $foto = $request->file('foto');

        $filename = time()
            . '_'
            . Str::random(10)
            . '.'
            . strtolower($foto->getClientOriginalExtension());

        $foto->move($uploadPath, $filename);

        Kadis::create([
            'nama'           => $validated['nama'],
            'jabatan'        => $validated['jabatan'],
            'periode'        => $validated['periode'],
            'status_id'      => 1,
            'foto'           => $filename,
            'created_by'     => Auth::user()->name,
            'updated_by'     => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.data-kadis.index')
            ->with('success', 'Data pejabat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pejabat.
     */
    public function show($id)
    {
        $kadis = Kadis::with('namabidang')->findOrFail($id);

        return view('administrator.kadis.show', compact('kadis'));
    }

    /**
     * Menampilkan form edit pejabat.
     */
    public function edit($id)
    {
        $kadis = Kadis::findOrFail($id);

        return view('administrator.kadis.edit', compact('kadis'));
    }

    /**
     * Memperbarui data pejabat.
     */
    public function update(Request $request, $id)
    {
        $kadis = Kadis::findOrFail($id);

        $validated = $request->validate([
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:3072',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'periode' => [
                'required',
                'string',
                'max:255',
            ],

        ], [
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Foto hanya boleh berformat JPG, JPEG, atau PNG.',
            'foto.max'   => 'Ukuran foto maksimal 3 MB.',

            'nama.required' => 'Nama pejabat wajib diisi.',
            'nama.string'   => 'Nama pejabat harus berupa teks.',
            'nama.max'      => 'Nama pejabat maksimal 255 karakter.',

            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string'   => 'Jabatan harus berupa teks.',
            'jabatan.max'      => 'Jabatan maksimal 255 karakter.',

            'periode.required' => 'Periode wajib diisi.',
            'periode.string'   => 'Periode harus berupa teks.',
            'periode.max'      => 'Periode maksimal 255 karakter.',

        ]);

        $filename = $kadis->foto;

        /*
         * Jika ada foto baru.
         */
        if ($request->hasFile('foto')) {
            $uploadPath = public_path('uploads_files/kadis');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            /*
             * Hapus foto lama.
             */
            if (
                $kadis->foto &&
                File::exists($uploadPath . '/' . $kadis->foto)
            ) {
                File::delete($uploadPath . '/' . $kadis->foto);
            }

            $foto = $request->file('foto');

            $filename = time()
                . '_'
                . Str::random(10)
                . '.'
                . strtolower($foto->getClientOriginalExtension());

            $foto->move($uploadPath, $filename);
        }

        $kadis->update([
            'nama'           => $validated['nama'],
            'jabatan'        => $validated['jabatan'],
            'periode'        => $validated['periode'],
            'foto'           => $filename,
            'updated_by'     => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.data-kadis.index')
            ->with('success', 'Data pejabat berhasil diperbarui.');
    }

    /**
     * Menghapus data pejabat.
     */
    public function destroy($id)
    {
        $kadis = Kadis::findOrFail($id);

        /*
         * Hapus foto dari folder public.
         */
        if ($kadis->foto) {
            $fotoPath = public_path(
                'uploads_files/kadis/' . $kadis->foto
            );

            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
        }

        $kadis->delete();

        return redirect()
            ->route('panel.data-kadis.index')
            ->with('success', 'Data pejabat berhasil dihapus.');
    }

    /**
     * Mengubah status aktif/nonaktif pejabat.
     */
    public function status($id)
    {
        $kadis = Kadis::findOrFail($id);

        $kadis->update([
            'status_id' => $kadis->status_id == 1 ? 0 : 1,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.data-kadis.index')
            ->with('success', 'Status pejabat berhasil diubah.');
    }
}
