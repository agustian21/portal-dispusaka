<?php

namespace App\Http\Controllers\otomasi;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function index()
    {
        $data = Alamat::first();

        return view('administrator.profilppid.alamat', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'singkatan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'link_maps' => ['nullable', 'string'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
        ], [
            'nama.required'      => 'Nama instansi wajib diisi.',
            'singkatan.required' => 'Singkatan instansi wajib diisi.',
            'alamat.required'    => 'Alamat wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
        ]);

        // Data alamat hanya menggunakan satu record
        if (Alamat::exists()) {
            return redirect()
                ->route('panel.alamat.index')
                ->with('error', 'Data alamat sudah tersedia.');
        }

        Alamat::create([
            'nama' => $request->nama,
            'singkatan' => $request->singkatan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'link_maps' => $request->link_maps,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'created_by' => $request->user()->name,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.alamat.index')
            ->with('success', 'Data alamat berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'singkatan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'email' => ['required', 'email', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'link_maps' => ['nullable', 'string'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
        ], [
            'nama.required'      => 'Nama instansi wajib diisi.',
            'singkatan.required' => 'Singkatan instansi wajib diisi.',
            'alamat.required'    => 'Alamat wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
        ]);

        $data = Alamat::findOrFail($id);

        $data->update([
            'nama' => $request->nama,
            'singkatan' => $request->singkatan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'link_maps' => $request->link_maps,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'updated_by' => $request->user()->name,
        ]);

        return redirect()
            ->route('panel.alamat.index')
            ->with('success', 'Data alamat berhasil diperbarui.');
    }
}
