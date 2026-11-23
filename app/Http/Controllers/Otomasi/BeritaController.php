<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowedRows = [25, 50, 100];

        $perPage = (int) $request->get(
            'rows',
            25
        );

        if (!in_array(
            $perPage,
            $allowedRows,
            true
        )) {
            $perPage = 25;
        }

        //Filter
        $search = trim(
            (string) $request->get('search', '')
        );

        $tanggalMulai = trim(
            (string) $request->get('tanggal_mulai', '')
        );

        $tanggalAkhir = trim(
            (string) $request->get('tanggal_akhir', '')
        );

        $query = Berita::query()
            ->select([
                'id',
                'judul',
                'tgl',
                'gambar',
                'status_id',
                'dibaca',
                'created_by',
                'updated_by',
            ]);

        //Search

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('created_by', 'like', '%' . $search . '%')
                    ->orWhere('updated_by', 'like', '%' . $search . '%');
            });
        }

        //Tanggal Mulai
        if ($tanggalMulai !== '') {
            $query->whereDate('tgl', '>=', $tanggalMulai);
        }

        //Tanggal Akhir
        if ($tanggalAkhir !== '') {
            $query->whereDate('tgl', '<=', $tanggalAkhir);
        }

        //Pagination

        $berita = $query
            ->orderByDesc('tgl')
            ->orderByDesc('id')
            ->simplePaginate($perPage)
            ->withQueryString();


        return view('administrator.berita.index', compact('berita', 'perPage', 'search', 'tanggalMulai', 'tanggalAkhir'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
         * Normalisasi slug sebelum validasi unique.
         */
        $request->merge([
            'slug_judul' => Str::slug(
                $request->input('slug_judul')
                    ?: $request->input('judul')
            ),
        ]);

        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'slug_judul' => [
                'required',
                'string',
                'max:255',
                'unique:berita,slug_judul',
            ],

            'tgl' => [
                'required',
                'date',
            ],

            'gambar' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'isi' => [
                'required',
                'string',
            ],

            'dibaca' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'slug_judul.required' => 'Slug berita wajib diisi.',
            'slug_judul.unique' => 'Slug berita sudah digunakan.',
            'tgl.required' => 'Tanggal berita wajib diisi.',
            'gambar.required' => 'Gambar utama wajib diunggah.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar hanya boleh JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'isi.required' => 'Isi berita wajib diisi.',
            'dibaca.integer' => 'Jumlah pembaca harus berupa angka.',
        ]);

        /*
         * Upload langsung ke:
         *
         * public/uploads_files/berita
         *
         * Tidak menggunakan Storage.
         */
        $gambar = $this->uploadImage($request);

        $sumber = 'PPID Pelaksana Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah';

        try {
            Berita::create([
                'judul' => $validated['judul'],
                'slug_judul' => $validated['slug_judul'],
                'tgl' => $validated['tgl'],
                'isi' => $validated['isi'],
                'gambar' => $gambar,
                'status_id' => 1,
                'description' => $validated['judul'] . ', Sumber : ' . $sumber,
                'dibaca' => (int) ($validated['dibaca'] ?? 0),
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);
        } catch (Throwable $e) {
            /*
             * Kalau insert database gagal,
             * hapus file yang telanjur diupload.
             */
            $this->deleteImage($gambar);

            throw $e;
        }

        return redirect()
            ->route('panel.berita.index')
            ->with(
                'success',
                'Berita berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('panel.berita.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::query()
            ->select([
                'id',
                'judul',
                'slug_judul',
                'tgl',
                'isi',
                'gambar',
                'description',
                'status_id',
                'dibaca',
                'created_by',
                'updated_by',
            ])
            ->findOrFail($id);

        return view('administrator.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::query()
            ->select([
                'id',
                'judul',
                'slug_judul',
                'tgl',
                'isi',
                'gambar',
                'description',
                'status_id',
                'dibaca',
                'created_by',
                'updated_by',
            ])
            ->findOrFail($id);

        $request->merge([
            'slug_judul' => Str::slug(
                $request->input('slug_judul')
                    ?: $request->input('judul')
            ),
        ]);

        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'slug_judul' => [
                'required',
                'string',
                'max:255',

                Rule::unique(
                    'berita',
                    'slug_judul'
                )->ignore($berita->id),
            ],

            'tgl' => [
                'required',
                'date',
            ],

            /*
             * Saat edit gambar tidak wajib diganti.
             */
            'gambar' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'isi' => [
                'required',
                'string',
            ],

            'dibaca' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'slug_judul.required' => 'Slug berita wajib diisi.',
            'slug_judul.unique' => 'Slug berita sudah digunakan.',
            'tgl.required' => 'Tanggal berita wajib diisi.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar hanya boleh JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'isi.required' => 'Isi berita wajib diisi.',
            'dibaca.integer' => 'Jumlah pembaca harus berupa angka.',
            'status_id.required' => 'Status berita wajib dipilih.',
        ]);

        $gambarLama = $berita->gambar;
        $gambarBaru = null;
        $sumber = 'PPID Pelaksana Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah';

        /*
         * Upload hanya jika pengguna
         * memilih gambar baru.
         */
        if ($request->hasFile('gambar')) {
            $gambarBaru = $this->uploadImage($request);
        }

        $dataUpdate = [
            'judul' => $validated['judul'],
            'slug_judul' => $validated['slug_judul'],
            'tgl' => $validated['tgl'],
            'isi' => $validated['isi'],
            'description' => $validated['judul'] . ', Sumber : ' . $sumber,
            'dibaca' => (int) (
                $validated['dibaca']
                ?? $berita->dibaca
                ?? 0
            ),
            'updated_by' => Auth::user()->name,
        ];

        if ($gambarBaru !== null) {
            $dataUpdate['gambar'] = $gambarBaru;
        }

        try {
            $berita->update($dataUpdate);
        } catch (Throwable $e) {
            /*
             * Jika database gagal update,
             * hapus gambar baru.
             *
             * Gambar lama tetap aman.
             */
            if ($gambarBaru !== null) {
                $this->deleteImage($gambarBaru);
            }

            throw $e;
        }

        /*
         * Database sudah berhasil update.
         * Baru gambar lama dihapus.
         */
        if (
            $gambarBaru !== null
            && $gambarLama
            && $gambarLama !== $gambarBaru
        ) {
            $this->deleteImage(
                $gambarLama
            );
        }

        return redirect()->route('panel.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::query()->select(['id', 'gambar',])->findOrFail($id);
        $gambar = $berita->gambar;

        $berita->delete();

        if ($gambar) {
            $this->deleteImage($gambar);
        }

        return redirect()->route('panel.berita.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Toggle status berita.
     */
    public function status(string $id)
    {
        $updated = Berita::query()
            ->whereKey($id)
            ->update([
                'status_id' => DB::raw(
                    'CASE
                        WHEN status_id = 1 THEN 0
                        ELSE 1
                    END'
                ),
                'updated_by' => Auth::user()->name,
            ]);

        if ($updated === 0) {
            abort(404);
        }

        return back()->with('success', 'Status berita berhasil diubah.');
    }

    /**
     * Upload gambar berita langsung ke public.
     */
    private function uploadImage(Request $request): string
    {
        $file = $request->file('gambar');

        $directory = public_path('uploads_files/berita');

        if (
            !is_dir($directory)
            && !mkdir(
                $directory,
                0755,
                true
            )
            && !is_dir($directory)
        ) {
            throw new \RuntimeException(
                'Folder upload berita tidak dapat dibuat.'
            );
        }

        $extension = strtolower($file->getClientOriginalExtension());

        $filename = Str::uuid()->toString() . '.' . $extension;

        $file->move($directory, $filename);

        return $filename;
    }

    private function deleteImage(?string $filename): void
    {
        if (!$filename) {
            return;
        }

        $filename = basename($filename);

        $path = public_path('uploads_files/berita/' . $filename);

        if (is_file($path)) {
            @unlink($path);
        }
    }

    public function exportPdf(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Ambil Filter
    |--------------------------------------------------------------------------
    */

        $search = trim(
            (string) $request->get('search', '')
        );

        $tanggalMulai = trim(
            (string) $request->get('tanggal_mulai', '')
        );

        $tanggalAkhir = trim(
            (string) $request->get('tanggal_akhir', '')
        );


        /*
    |--------------------------------------------------------------------------
    | Query Berita
    |--------------------------------------------------------------------------
    */

        $query = Berita::query()
            ->select([
                'id',
                'judul',
                'tgl',
                'gambar',
                'status_id',
                'dibaca',
                'created_by',
                'updated_by',
            ]);


        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('created_by', 'like', '%' . $search . '%')
                    ->orWhere('updated_by', 'like', '%' . $search . '%');
            });
        }


        /*
    |--------------------------------------------------------------------------
    | Tanggal Mulai
    |--------------------------------------------------------------------------
    */

        if ($tanggalMulai !== '') {

            $query->whereDate(
                'tgl',
                '>=',
                $tanggalMulai
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Tanggal Akhir
    |--------------------------------------------------------------------------
    */

        if ($tanggalAkhir !== '') {

            $query->whereDate(
                'tgl',
                '<=',
                $tanggalAkhir
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Get Data
    |--------------------------------------------------------------------------
    */

        $berita = $query
            ->orderByDesc('tgl')
            ->orderByDesc('id')
            ->get();


        /*
    |--------------------------------------------------------------------------
    | Generate PDF
    |--------------------------------------------------------------------------
    */

        $pdf = Pdf::loadView(
            'administrator.berita.pdf',
            [
                'berita' => $berita,
                'search' => $search,
                'tanggalMulai' => $tanggalMulai,
                'tanggalAkhir' => $tanggalAkhir,
            ]
        );


        $pdf->setPaper(
            'a4',
            'landscape'
        );


        /*
    |--------------------------------------------------------------------------
    | Nama File
    |--------------------------------------------------------------------------
    */

        $filename = 'data-berita';

        if ($tanggalMulai !== '') {
            $filename .= '-dari-' . $tanggalMulai;
        }

        if ($tanggalAkhir !== '') {
            $filename .= '-sampai-' . $tanggalAkhir;
        }

        $filename .= '.pdf';


        return $pdf->download($filename);
    }
}
