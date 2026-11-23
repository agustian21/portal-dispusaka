<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Pejabat;
use App\Models\Namabidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PejabatController extends Controller
{
    /**
     * Menampilkan seluruh data pejabat.
     */
    public function index()
    {
        $pejabat = Pejabat::with('namabidang')
            ->orderBy('id', 'desc')
            ->get();

        return view('administrator.pejabat.index', compact('pejabat'));
    }

    /**
     * Menampilkan form tambah pejabat.
     */
    public function create()
    {
        $namabidang = Namabidang::orderBy('id', 'asc')->get();

        return view('administrator.pejabat.create', compact('namabidang'));
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

            'nip' => [
                'required',
                'digits:18',
            ],

            'pangkat' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'namabidang_id' => [
                'required',
                Rule::exists((new Namabidang)->getTable(), 'id'),
            ],
        ], [
            'foto.required' => 'Foto pejabat wajib diunggah.',
            'foto.image'    => 'File yang diunggah harus berupa gambar.',
            'foto.mimes'    => 'Foto hanya boleh berformat JPG, JPEG, atau PNG.',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',

            'nama.required' => 'Nama pejabat wajib diisi.',
            'nama.string'   => 'Nama pejabat harus berupa teks.',
            'nama.max'      => 'Nama pejabat maksimal 255 karakter.',

            'nip.required' => 'NIP wajib diisi.',
            'nip.digits'   => 'NIP harus terdiri dari 18 digit angka.',

            'pangkat.required' => 'Pangkat/Golongan wajib diisi.',
            'pangkat.string'   => 'Pangkat/Golongan harus berupa teks.',
            'pangkat.max'      => 'Pangkat/Golongan maksimal 255 karakter.',

            'jabatan.required' => 'Jabatan wajib dipilih.',
            'jabatan.string'   => 'Jabatan tidak valid.',
            'jabatan.max'      => 'Jabatan maksimal 255 karakter.',

            'namabidang_id.required' => 'Bidang wajib dipilih.',
            'namabidang_id.exists'   => 'Bidang yang dipilih tidak ditemukan.',
        ]);

        $uploadPath = public_path('uploads_files/pejabat');

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

        Pejabat::create([
            'nama'           => $validated['nama'],
            'nip'            => $validated['nip'],
            'pangkat/gol'    => $validated['pangkat'],
            'jabatan'        => $validated['jabatan'],
            'namabidang_id'  => $validated['namabidang_id'],
            'status_id'      => 1,
            'foto'           => $filename,
            'created_by'     => Auth::user()->name,
            'updated_by'     => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.data-pejabat.index')
            ->with('success', 'Data pejabat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pejabat.
     */
    public function show($id)
    {
        $pejabat = Pejabat::with('namabidang')->findOrFail($id);

        return view('administrator.pejabat.show', compact('pejabat'));
    }

    /**
     * Menampilkan form edit pejabat.
     */
    public function edit($id)
    {
        $pejabat = Pejabat::findOrFail($id);

        $namabidang = Namabidang::orderBy('id', 'asc')->get();

        return view('administrator.pejabat.edit', compact('pejabat', 'namabidang'));
    }

    /**
     * Memperbarui data pejabat.
     */
    public function update(Request $request, $id)
    {
        $pejabat = Pejabat::findOrFail($id);

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

            'nip' => [
                'required',
                'digits:18',
            ],

            'pangkat' => [
                'required',
                'string',
                'max:255',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'namabidang_id' => [
                'required',
                Rule::exists((new Namabidang)->getTable(), 'id'),
            ],
        ], [
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Foto hanya boleh berformat JPG, JPEG, atau PNG.',
            'foto.max'   => 'Ukuran foto maksimal 3 MB.',

            'nama.required' => 'Nama pejabat wajib diisi.',
            'nama.string'   => 'Nama pejabat harus berupa teks.',
            'nama.max'      => 'Nama pejabat maksimal 255 karakter.',

            'nip.required' => 'NIP wajib diisi.',
            'nip.digits'   => 'NIP harus terdiri dari 18 digit angka.',

            'pangkat.required' => 'Pangkat/Golongan wajib diisi.',
            'pangkat.string'   => 'Pangkat/Golongan harus berupa teks.',
            'pangkat.max'      => 'Pangkat/Golongan maksimal 255 karakter.',

            'jabatan.required' => 'Jabatan wajib dipilih.',
            'jabatan.string'   => 'Jabatan tidak valid.',
            'jabatan.max'      => 'Jabatan maksimal 255 karakter.',

            'namabidang_id.required' => 'Bidang wajib dipilih.',
            'namabidang_id.exists'   => 'Bidang yang dipilih tidak ditemukan.',
        ]);

        $filename = $pejabat->foto;

        /*
         * Jika ada foto baru.
         */
        if ($request->hasFile('foto')) {
            $uploadPath = public_path('uploads_files/pejabat');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            /*
             * Hapus foto lama.
             */
            if (
                $pejabat->foto &&
                File::exists($uploadPath . '/' . $pejabat->foto)
            ) {
                File::delete($uploadPath . '/' . $pejabat->foto);
            }

            $foto = $request->file('foto');

            $filename = time()
                . '_'
                . Str::random(10)
                . '.'
                . strtolower($foto->getClientOriginalExtension());

            $foto->move($uploadPath, $filename);
        }

        $pejabat->update([
            'nama'           => $validated['nama'],
            'nip'            => $validated['nip'],
            'pangkat/gol'    => $validated['pangkat'],
            'jabatan'        => $validated['jabatan'],
            'namabidang_id'  => $validated['namabidang_id'],
            'foto'           => $filename,
            'updated_by'     => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.data-pejabat.index')
            ->with('success', 'Data pejabat berhasil diperbarui.');
    }

    /**
     * Menghapus data pejabat.
     */
    public function destroy($id)
    {
        $pejabat = Pejabat::findOrFail($id);

        /*
         * Hapus foto dari folder public.
         */
        if ($pejabat->foto) {
            $fotoPath = public_path(
                'uploads_files/pejabat/' . $pejabat->foto
            );

            if (File::exists($fotoPath)) {
                File::delete($fotoPath);
            }
        }

        $pejabat->delete();

        return redirect()
            ->route('panel.data-pejabat.index')
            ->with('success', 'Data pejabat berhasil dihapus.');
    }

    /**
     * Mengubah status aktif/nonaktif pejabat.
     */
    public function status($id)
    {
        $pejabat = Pejabat::findOrFail($id);

        $pejabat->update([
            'status_id' => $pejabat->status_id == 1 ? 0 : 1,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.data-pejabat.index')
            ->with('success', 'Status pejabat berhasil diubah.');
    }
}
