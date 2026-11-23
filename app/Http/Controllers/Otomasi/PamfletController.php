<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Pamflet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PamfletController extends Controller
{
    /**
     * Menampilkan daftar pamflet.
     */
    public function index()
    {
        $pamflets = Pamflet::query()->latest('id')->get();
        return view('administrator.pamflet.index', compact('pamflets'));
    }

    /**
     * Menampilkan halaman tambah pamflet.
     */
    public function create()
    {
        return view('administrator.pamflet.create');
    }

    /**
     * Menyimpan pamflet baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nm_pamflet' => ['required', 'string', 'max:255',],
            'deskripsi' => ['required', 'string',],
            'gambar' => ['required', 'array', 'min:1',],
            'gambar.*' => ['required', 'image', 'mimes:jpg,jpeg', 'max:5120',],
        ], [
            'nm_pamflet.required' => 'Nama pamflet wajib diisi.',
            'nm_pamflet.max'      => 'Nama pamflet maksimal 255 karakter.',
            'deskripsi.required' => 'Deskripsi pamflet wajib diisi.',
            'gambar.required' => 'Minimal satu gambar wajib diunggah.',
            'gambar.array'    => 'Format upload gambar tidak valid.',
            'gambar.min'      => 'Minimal satu gambar wajib diunggah.',

            'gambar.*.required' => 'File gambar wajib dipilih.',
            'gambar.*.image'    => 'File yang diunggah harus berupa gambar.',
            'gambar.*.mimes'    => 'Format gambar hanya boleh JPG atau JPEG.',
            'gambar.*.max'      => 'Ukuran setiap gambar maksimal 5 MB.',
        ]);

        $namaGambar = $this->uploadImages(
            $request->file('gambar')
        );

        try {
            Pamflet::create([
                'nm_pamflet'   => $validated['nm_pamflet'],
                'slug_pamflet' => $this->generateUniqueSlug($validated['nm_pamflet']),
                'deskripsi'    => $validated['deskripsi'],
                'gambar'       => $namaGambar,
                'status_id'    => 1,
                'created_by'   => Auth::user()->name,
                'updated_by'   => Auth::user()->name,
            ]);
        } catch (\Throwable $e) {

            // Jika proses database gagal,
            // hapus gambar yang sudah terlanjur diupload.
            $this->deleteImages($namaGambar);

            throw $e;
        }

        return redirect()
            ->route('panel.pamflet.index')
            ->with(
                'success',
                'Pamflet berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail pamflet.
     */
    public function show(string $id)
    {
        $pamflet = Pamflet::findOrFail($id);
        return view('administrator.pamflet.show', compact('pamflet'));
    }

    /**
     * Menampilkan halaman edit.
     */
    public function edit(string $id)
    {
        $pamflet = Pamflet::findOrFail($id);
        return view('administrator.pamflet.edit', compact('pamflet'));
    }

    /**
     * Memperbarui pamflet.
     */
    public function update(Request $request, string $id)
    {
        $pamflet = Pamflet::findOrFail($id);
        $validated = $request->validate([
            'nm_pamflet' => ['required', 'string', 'max:255',],
            'deskripsi' => ['required', 'string',],
            'gambar' => ['nullable', 'array',],
            'gambar.*' => ['image', 'mimes:jpg,jpeg', 'max:5120',],
            'hapus_gambar' => ['nullable', 'array',],
            'hapus_gambar.*' => ['string',],
        ], [
            'nm_pamflet.required' => 'Nama pamflet wajib diisi.',
            'nm_pamflet.max'      => 'Nama pamflet maksimal 255 karakter.',
            'deskripsi.required'  => 'Deskripsi pamflet wajib diisi.',
            'gambar.array'        => 'Format upload gambar tidak valid.',
            'gambar.*.image'      => 'File yang diunggah harus berupa gambar.',
            'gambar.*.mimes'      => 'Format gambar hanya boleh JPG atau JPEG.',
            'gambar.*.max'        => 'Ukuran setiap gambar maksimal 5 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ambil gambar yang sudah ada
        |--------------------------------------------------------------------------
        */

        $gambarSaatIni = $pamflet->gambar ?? [];

        if (!is_array($gambarSaatIni)) {
            $gambarSaatIni = [];
        }

        /*
        |--------------------------------------------------------------------------
        | Tentukan gambar yang ingin dihapus
        |--------------------------------------------------------------------------
        */

        $requestHapus = $request->input(
            'hapus_gambar',
            []
        );

        /*
         * array_intersect mencegah pengguna memasukkan
         * nama file sembarangan melalui request.
         */
        $gambarDihapus = array_values(
            array_intersect(
                $requestHapus,
                $gambarSaatIni
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Gambar yang tetap dipertahankan
        |--------------------------------------------------------------------------
        */

        $gambarTersisa = array_values(
            array_diff(
                $gambarSaatIni,
                $gambarDihapus
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Upload gambar baru
        |--------------------------------------------------------------------------
        */

        $gambarBaru = [];

        if ($request->hasFile('gambar')) {
            $gambarBaru = $this->uploadImages(
                $request->file('gambar')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Gabungkan gambar lama + baru
        |--------------------------------------------------------------------------
        */

        $semuaGambar = array_values(
            array_merge(
                $gambarTersisa,
                $gambarBaru
            )
        );

        /*
         * Pamflet wajib memiliki minimal satu gambar.
         */
        if (empty($semuaGambar)) {

            $this->deleteImages($gambarBaru);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'gambar' =>
                    'Pamflet wajib memiliki minimal satu gambar.',
                ]);
        }

        try {
            $pamflet->update([
                'nm_pamflet' =>
                $validated['nm_pamflet'],

                'slug_pamflet' =>
                $this->generateUniqueSlug(
                    $validated['nm_pamflet'],
                    $pamflet->id
                ),

                'deskripsi' =>
                $validated['deskripsi'],

                'gambar' =>
                $semuaGambar,

                'updated_by' =>
                Auth::user()->name,
            ]);
        } catch (\Throwable $e) {

            /*
             * Jika database gagal diperbarui,
             * hapus file baru supaya tidak menjadi orphan.
             */
            $this->deleteImages($gambarBaru);

            throw $e;
        }

        /*
         * Database berhasil diperbarui.
         * Sekarang file lama yang dipilih untuk dihapus
         * dapat dihapus secara fisik.
         */
        if (!empty($gambarDihapus)) {
            $this->deleteImages($gambarDihapus);
        }

        return redirect()
            ->route('panel.pamflet.index')
            ->with(
                'success',
                'Pamflet berhasil diperbarui.'
            );
    }

    /**
     * Menghapus pamflet.
     */
    public function destroy(string $id)
    {
        $pamflet = Pamflet::findOrFail($id);

        $gambar = $pamflet->gambar ?? [];

        if (is_array($gambar)) {
            $this->deleteImages($gambar);
        }

        $pamflet->delete();

        return redirect()
            ->route('panel.pamflet.index')
            ->with(
                'success',
                'Pamflet berhasil dihapus.'
            );
    }

    /**
     * Mengubah status pamflet.
     *
     * 1 = Aktif
     * 0 = Tidak Aktif
     */
    public function status(string $id)
    {
        $pamflet = Pamflet::findOrFail($id);

        $pamflet->update([
            'status_id' =>
            $pamflet->status_id == 1 ? 0 : 1,

            'updated_by' =>
            Auth::user()->name,
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Status pamflet berhasil diubah.'
            );
    }

    /**
     * Upload banyak gambar.
     */
    private function uploadImages(array $files): array
    {
        $folder = public_path(
            'uploads_files/pamflet'
        );

        if (!File::exists($folder)) {
            File::makeDirectory(
                $folder,
                0755,
                true
            );
        }

        $hasil = [];

        foreach ($files as $file) {
            $extension = strtolower(
                $file->getClientOriginalExtension()
            );
            $namaFile = now()->format('YmdHis') . '_' . Str::random(16) . '.' . $extension;
            $file->move($folder, $namaFile);
            $hasil[] = $namaFile;
        }
        return $hasil;
    }

    /**
     * Menghapus satu atau banyak gambar.
     */
    private function deleteImages(array $images): void
    {
        foreach ($images as $image) {

            /*
             * basename digunakan sebagai perlindungan
             * tambahan terhadap path traversal.
             */
            $namaFile = basename($image);

            $path = public_path('uploads_files/pamflet/' . $namaFile);

            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

    /**
     * Membuat slug unik.
     */
    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nama);
        if (empty($baseSlug)) {
            $baseSlug = 'pamflet';
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
            $this->slugExists(
                $slug,
                $ignoreId
            )
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Memeriksa slug.
     */
    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = Pamflet::query()
            ->where('slug_pamflet', $slug);

        if ($ignoreId !== null) {
            $query->where(
                'id',
                '!=',
                $ignoreId
            );
        }

        return $query->exists();
    }
}
