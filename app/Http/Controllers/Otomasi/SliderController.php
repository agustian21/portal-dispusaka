<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Throwable;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider = Slider::latest()->paginate(10);

        return view('administrator.slider.index', compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nm_slide' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'gambar' => [
                    'required',
                    'image',
                    'mimes:jpg,jpeg,png',
                    'max:1024',
                    'dimensions:width=1180,height=590',
                ],
            ],
            [
                'nm_slide.required' => 'Judul slider wajib diisi.',
                'nm_slide.string' => 'Judul slider harus berupa teks.',
                'nm_slide.max' => 'Judul slider maksimal 255 karakter.',

                'gambar.required' => 'Gambar slider wajib diunggah.',
                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Gambar hanya boleh berformat JPG, JPEG, atau PNG.',
                'gambar.max' => 'Ukuran gambar maksimal 1 MB.',
                'gambar.dimensions' => 'Dimensi gambar wajib tepat 1180 × 590 px.',
            ]
        );

        $uploadPath = public_path('uploads_files/slider');

        if (!File::isDirectory($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $file = $request->file('gambar');

        $extension = strtolower($file->getClientOriginalExtension());

        $fileName = Str::uuid()->toString() . '.' . $extension;

        $file->move($uploadPath, $fileName);

        try {
            Slider::create([
                'nm_slide' => $validated['nm_slide'],
                'gambar' => $fileName,
                'status_id' => 1,
                'created_by' => Auth::user()->name,
                'updated_by' => Auth::user()->name,
            ]);
        } catch (Throwable $e) {
            $newImagePath = $uploadPath . DIRECTORY_SEPARATOR . $fileName;

            if (File::exists($newImagePath)) {
                File::delete($newImagePath);
            }

            throw $e;
        }

        return redirect()
            ->route('panel.slider-website.index')
            ->with('success', 'Slider website berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $slider = Slider::findOrFail($id);

        return redirect()
            ->route('panel.slider-website.edit', $slider->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);

        return view('administrator.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $slider = Slider::findOrFail($id);

        $validated = $request->validate(
            [
                'nm_slide' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'gambar' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png',
                    'max:1024',
                    'dimensions:width=1180,height=590',
                ],
            ],
            [
                'nm_slide.required' => 'Judul slider wajib diisi.',
                'nm_slide.string' => 'Judul slider harus berupa teks.',
                'nm_slide.max' => 'Judul slider maksimal 255 karakter.',

                'gambar.image' => 'File yang diunggah harus berupa gambar.',
                'gambar.mimes' => 'Gambar hanya boleh berformat JPG, JPEG, atau PNG.',
                'gambar.max' => 'Ukuran gambar maksimal 1 MB.',
                'gambar.dimensions' => 'Dimensi gambar wajib tepat 1180 × 590 px.',
            ]
        );

        $data = [
            'nm_slide' => $validated['nm_slide'],
            'updated_by' => Auth::user()->name,
        ];

        $uploadPath = public_path('uploads_files/slider');

        $newFileName = null;
        $oldFileName = $slider->gambar;

        if ($request->hasFile('gambar')) {

            if (!File::isDirectory($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            $file = $request->file('gambar');

            $extension = strtolower($file->getClientOriginalExtension());

            $newFileName = Str::uuid()->toString() . '.' . $extension;

            $file->move($uploadPath, $newFileName);

            $data['gambar'] = $newFileName;
        }

        try {
            $slider->update($data);
        } catch (Throwable $e) {

            if ($newFileName) {
                $newImagePath = $uploadPath
                    . DIRECTORY_SEPARATOR
                    . $newFileName;

                if (File::exists($newImagePath)) {
                    File::delete($newImagePath);
                }
            }

            throw $e;
        }

        /*
         * Hapus gambar lama hanya setelah
         * database berhasil diperbarui.
         */
        if ($newFileName && $oldFileName) {

            $oldImagePath = $uploadPath
                . DIRECTORY_SEPARATOR
                . basename($oldFileName);

            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        return redirect()
            ->route('panel.slider-website.index')
            ->with('success', 'Slider website berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        $fileName = $slider->gambar;

        /*
         * Hapus data database terlebih dahulu.
         */
        $slider->delete();

        /*
         * Kemudian hapus gambar dari public.
         */
        if ($fileName) {

            $filePath = public_path(
                'uploads_files/slider/' . basename($fileName)
            );

            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        return redirect()
            ->route('panel.slider-website.index')
            ->with('success', 'Slider website berhasil dihapus.');
    }

    /**
     * Mengubah status slider.
     */
    public function status($id)
    {
        $slider = Slider::findOrFail($id);

        $slider->update([
            'status_id' => (int) $slider->status_id === 1 ? 0 : 1,
            'updated_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('panel.slider-website.index')
            ->with('success', 'Status slider website berhasil diubah.');
    }
}
