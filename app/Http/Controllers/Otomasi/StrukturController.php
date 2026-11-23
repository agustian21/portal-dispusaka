<?php

namespace App\Http\Controllers\otomasi;

use App\Http\Controllers\Controller;
use App\Models\Struktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StrukturController extends Controller
{
    /**
     * Menampilkan data struktur organisasi.
     */
    public function index()
    {
        $data = Struktur::first();

        return view('administrator.instansi.struktur', compact('data'));
    }

    /**
     * Menyimpan struktur organisasi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'gambar.required' => 'Gambar struktur organisasi wajib diunggah.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        // Struktur organisasi hanya menggunakan satu record
        if (Struktur::exists()) {
            return redirect()
                ->route('panel.struktur-organisasi.index')
                ->with('error', 'Data struktur organisasi sudah tersedia.');
        }

        $namaGambar = null;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            $folder = public_path('uploads_files/profil');

            // Buat folder jika belum tersedia
            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            $namaGambar = 'struktur_' .
                time() . '_' .
                uniqid() . '.' .
                $file->getClientOriginalExtension();

            $file->move($folder, $namaGambar);
        }

        Struktur::create([
            'gambar' => $namaGambar,
            'created_by' => $request->user()->name,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.struktur-organisasi.index')
            ->with('success', 'Struktur organisasi berhasil disimpan.');
    }

    /**
     * Memperbarui struktur organisasi.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ], [
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 5 MB.',
        ]);

        $data = Struktur::findOrFail($id);

        $namaGambar = $data->gambar;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            $folder = public_path('uploads_files/profil');

            // Buat folder jika belum tersedia
            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            // Hapus gambar lama
            if (
                !empty($data->gambar) &&
                File::exists($folder . DIRECTORY_SEPARATOR . $data->gambar)
            ) {
                File::delete(
                    $folder . DIRECTORY_SEPARATOR . $data->gambar
                );
            }

            // Buat nama file baru
            $namaGambar = 'struktur_' .
                time() . '_' .
                uniqid() . '.' .
                $file->getClientOriginalExtension();

            // Simpan langsung ke public/uploads_files/profil
            $file->move($folder, $namaGambar);
        }

        $data->update([
            'gambar' => $namaGambar,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.struktur-organisasi.index')
            ->with('success', 'Struktur organisasi berhasil diperbarui.');
    }
}
