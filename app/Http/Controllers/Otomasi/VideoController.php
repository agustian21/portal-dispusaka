<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index()
    {
        $video = Video::orderBy('id', 'desc')->get();
        return view('administrator.video.index', compact('video'));
    }


    public function create()
    {
        return view('administrator.video.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required',
            'linkvideo' => 'required|url',
            'tglupload' => 'required|date',
        ], [
            'judul.required' => 'Judul video wajib diisi.',
            'linkvideo.required' => 'Link video wajib diisi.',
            'linkvideo.url'      => 'Link video harus berupa URL yang valid.',
            'tglupload.required' => 'Tanggal upload wajib diisi.',
            'tglupload.date'     => 'Tanggal upload harus berupa tanggal yang valid.',
        ]);

        Video::create([
            'judul'      => $request->judul,
            'linkvideo'  => $request->linkvideo,
            'tglupload'  => $request->tglupload,
            'status_id'  => 1,
            'created_by' => Auth::user()->name,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.video.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $video = Video::findOrFail($id);
        return view('administrator.video.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required',
            'linkvideo' => 'required|url',
            'tglupload' => 'required|date',
            'status_id' => 'required',
        ], [
            'judul.required' => 'Judul video wajib diisi.',

            'linkvideo.required' => 'Link video wajib diisi.',
            'linkvideo.url'      => 'Link video harus berupa URL yang valid.',
            'tglupload.required' => 'Tanggal upload wajib diisi.',
            'tglupload.date'     => 'Tanggal upload harus berupa tanggal yang valid.',
            'status_id.required' => 'Status video wajib dipilih.',
        ]);

        $video = Video::findOrFail($id);

        $video->update([
            'judul'      => $request->judul,
            'linkvideo'  => $request->linkvideo,
            'tglupload'  => $request->tglupload,
            'status_id'  => $request->status_id,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.video.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()
            ->route('panel.video.index')
            ->with('success', 'Video berhasil dihapus');
    }

    public function status($id)
    {
        $video = Video::findOrFail($id);
        $video->update([
            'status_id' => $video->status_id == 1 ? 0 : 1,
            'updated_by' => Auth::user()->name
        ]);

        return redirect()
            ->route('panel.video.index')
            ->with('success', 'Status video berhasil diubah');
    }
}
