<?php

namespace App\Http\Controllers\otomasi;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::first();

        return view('administrator.instansi.company', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
        ], [
            'visi.required' => 'Visi PPID wajib diisi.',
            'misi.required' => 'Misi PPID wajib diisi.',
        ]);

        // Karena visi dan misi hanya menggunakan satu record
        if (Company::exists()) {
            return redirect()
                ->route('panel.visi-misi-instansi.index')
                ->with('error', 'Data visi dan misi instansi sudah tersedia.');
        }

        Company::create([
            'visi' => $request->visi,
            'misi' => $request->misi,
            'created_by' => $request->user()->name,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.visi-misi-instansi.index')
            ->with('success', 'Visi dan misi instansi berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
        ], [
            'visi.required' => 'Visi PPID wajib diisi.',
            'misi.required' => 'Misi PPID wajib diisi.',
        ]);

        $data = Company::findOrFail($id);

        $data->update([
            'visi' => $request->visi,
            'misi' => $request->misi,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.visi-misi-instansi.index')
            ->with('success', 'Visi dan misi instansi berhasil diperbarui.');
    }
}
