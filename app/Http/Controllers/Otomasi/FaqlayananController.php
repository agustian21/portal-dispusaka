<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\FaqLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqLayananController extends Controller
{
    /**
     * Menampilkan daftar FAQ layanan.
     */
    public function index()
    {
        $faqlayanans = FaqLayanan::query()
            ->latest('id')
            ->get();

        return view('administrator.faqlayanan.index', compact('faqlayanans'));
    }

    /**
     * Menampilkan halaman tambah FAQ.
     */
    public function create()
    {
        return view('administrator.faqlayanan.create');
    }

    /**
     * Menyimpan FAQ baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'isi'       => ['required', 'string'],
        ], [
            'judul.required'     => 'Judul pertanyaan wajib diisi.',
            'judul.max'          => 'Judul pertanyaan maksimal 255 karakter.',
            'isi.required'       => 'Isi jawaban wajib diisi.',
        ]);

        FaqLayanan::create([
            'judul'      => $validated['judul'],
            'isi'        => $validated['isi'],
            'status_id'  => 1,
            'created_by' => Auth::user()->name,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.faqlayanan.index')
            ->with('success', 'FAQ layanan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail FAQ.
     */
    public function show(string $id)
    {
        $faqlayanan = FaqLayanan::findOrFail($id);

        return view(
            'administrator.faqlayanan.show',
            compact('faqlayanan')
        );
    }

    /**
     * Menampilkan halaman edit FAQ.
     */
    public function edit(string $id)
    {
        $faqlayanan = FaqLayanan::findOrFail($id);

        return view('administrator.faqlayanan.edit', compact('faqlayanan'));
    }

    /**
     * Memperbarui FAQ.
     */
    public function update(Request $request, string $id)
    {
        $faqlayanan = FaqLayanan::findOrFail($id);

        $validated = $request->validate([
            'judul'     => ['required', 'string', 'max:255'],
            'isi'       => ['required', 'string'],
            'status_id' => ['required', 'integer'],
        ], [
            'judul.required'     => 'Judul pertanyaan wajib diisi.',
            'judul.max'          => 'Judul pertanyaan maksimal 255 karakter.',
            'isi.required'       => 'Isi jawaban wajib diisi.',
        ]);

        $faqlayanan->update([
            'judul'      => $validated['judul'],
            'isi'        => $validated['isi'],
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.faqlayanan.index')
            ->with('success', 'FAQ layanan berhasil diperbarui.');
    }

    /**
     * Menghapus FAQ.
     */
    public function destroy(string $id)
    {
        $faqlayanan = FaqLayanan::findOrFail($id);

        $faqlayanan->delete();

        return redirect()
            ->route('panel.faqlayanan.index')
            ->with('success', 'FAQ layanan berhasil dihapus.');
    }

    /**
     * Mengubah status FAQ aktif / tidak aktif.
     *
     * Asumsi:
     * status_id = 1 -> Aktif
     * status_id = 2 -> Non-Aktif
     */
    public function status(string $id)
    {
        $faqlayanan = FaqLayanan::findOrFail($id);

        $faqlayanan->update([
            'status_id'  => $faqlayanan->status_id == 1 ? 0 : 1,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status FAQ layanan berhasil diubah.');
    }
}
