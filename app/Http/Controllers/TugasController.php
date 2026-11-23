<?php

namespace App\Http\Controllers;

use App\Models\Tugasppid;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class TugasController extends Controller
{
    /**
     * Menampilkan halaman Tugas dan Tanggung Jawab PPID.
     */
    public function index(): View
    {
        // ==========================================
        // AMBIL DATA TUGAS DAN TANGGUNG JAWAB PPID
        // ==========================================

        $tugasppid = Tugasppid::query()
            ->select([
                'tugasutama',
                'tugaspelaksana',
                'updated_at',
            ])
            ->orderByDesc('updated_at')
            ->first();

        $tugasUtamaItems = $this->toListItems(
            $tugasppid?->tugasutama
        );

        $tugasPelaksanaItems = $this->toListItems(
            $tugasppid?->tugaspelaksana
        );


        // ==========================================
        // SEO TUGAS DAN TANGGUNG JAWAB PPID
        // ==========================================

        $seoTitle = 'Tugas dan Tanggung Jawab PPID DISPUSAKA Sulawesi Tengah';

        // Gabungkan konten tugas utama dan pelaksana
        $seoContent = collect(array_merge(
            $tugasUtamaItems,
            $tugasPelaksanaItems
        ))
            ->filter()
            ->take(3)
            ->implode(' ');

        // Deskripsi SEO dinamis dari database
        $seoDescription = trim($seoContent) !== ''
            ? Str::limit(
                'Tugas dan tanggung jawab PPID DISPUSAKA Sulawesi Tengah meliputi '
                    . $seoContent,
                155,
                '...'
            )
            : 'Informasi tugas utama dan tanggung jawab PPID serta PPID Pelaksana DISPUSAKA Provinsi Sulawesi Tengah dalam pengelolaan dan pelayanan informasi publik.';

        $seoUrl = url()->current();

        $seoImage = asset('assets/images/Logo-Sulteng.png');


        // ==========================================
        // BASIC SEO
        // ==========================================

        SEOMeta::setTitle($seoTitle);
        SEOMeta::setDescription($seoDescription);
        SEOMeta::setCanonical($seoUrl);
        SEOMeta::setRobots('index,follow');

        SEOMeta::addMeta(
            'author',
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        SEOMeta::addKeyword([
            'Tugas dan Tanggung Jawab PPID DISPUSAKA',
            'Tugas PPID Sulawesi Tengah',
            'Tugas PPID Pelaksana Sulteng',
            'Fungsi PPID DISPUSAKA',
            'PPID DISPUSAKA Sulawesi Tengah',
            'Tugas Pejabat Pengelola Informasi dan Dokumentasi',
            'Pelayanan Informasi Publik',
            'Keterbukaan Informasi Publik',
            'Pengelolaan Informasi Publik',
            'Transparansi Informasi Pemerintah',
            'Dinas Perpustakaan dan Kearsipan Sulteng'
        ]);


        // ==========================================
        // OPEN GRAPH
        // ==========================================

        SEOTools::opengraph()->setTitle($seoTitle);
        SEOTools::opengraph()->setDescription($seoDescription);
        SEOTools::opengraph()->setUrl($seoUrl);

        SEOTools::opengraph()->addProperty(
            'type',
            'website'
        );

        SEOTools::opengraph()->addProperty(
            'locale',
            'id_ID'
        );

        SEOTools::opengraph()->addProperty(
            'site_name',
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        SEOTools::opengraph()->addImage($seoImage);


        // ==========================================
        // TWITTER CARD
        // ==========================================

        SEOTools::twitter()->setType('summary');
        SEOTools::twitter()->setTitle($seoTitle);
        SEOTools::twitter()->setDescription($seoDescription);
        SEOTools::twitter()->setUrl($seoUrl);
        SEOTools::twitter()->setImage($seoImage);


        // ==========================================
        // JSON-LD STRUCTURED DATA
        // ==========================================

        SEOTools::jsonLd()->setType('WebPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);


        // ==========================================
        // RETURN VIEW
        // ==========================================

        return view('home.ppid.tugas', [
            'tugasppid' => $tugasppid,
            'tugasUtamaItems' => $tugasUtamaItems,
            'tugasPelaksanaItems' => $tugasPelaksanaItems,
        ]);
    }

    /**
     * Mengubah isi editor menjadi array item yang bersih.
     *
     * Mendukung:
     * - plain text
     * - CKEditor / TinyMCE
     * - <p>
     * - <br>
     * - <li>
     * - daftar bernomor
     * - bullet list
     *
     * Contoh:
     *
     * 1. Menyediakan informasi...
     * 2. Mengelola dokumentasi...
     *
     * Menjadi:
     *
     * [
     *     'Menyediakan informasi...',
     *     'Mengelola dokumentasi...',
     * ]
     */
    private function toListItems(?string $value): array
    {
        if ($value === null || trim($value) === '') {
            return [];
        }

        $value = $this->normalizeEditorBreaks($value);

        $text = html_entity_decode(
            strip_tags($value),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $lines = preg_split('/\R+/u', $text) ?: [];

        return collect($lines)
            ->map(function (string $line): string {
                $line = trim($line);

                // Normalisasi spasi horizontal.
                $line = preg_replace(
                    '/\h+/u',
                    ' ',
                    $line
                ) ?? $line;

                /*
                 * Menghilangkan bullet/nomor lama, misalnya:
                 *
                 * - Item
                 * • Item
                 * * Item
                 * 1. Item
                 * 1) Item
                 * a. Item
                 * a) Item
                 */
                $line = preg_replace(
                    '/^\s*(?:[-•▪●*]+|(?:\d+|[A-Za-z])\s*[.)-])\s*/u',
                    '',
                    $line
                ) ?? $line;

                return trim($line);
            })
            ->filter(
                fn(string $line): bool => $line !== ''
            )
            ->values()
            ->all();
    }

    /**
     * Menormalkan line break dari editor WYSIWYG.
     */
    private function normalizeEditorBreaks(string $value): string
    {
        return preg_replace(
            [
                '/<\s*br\s*\/?\s*>/i',
                '/<\s*\/\s*p\s*>/i',
                '/<\s*\/\s*li\s*>/i',
                '/<\s*\/\s*div\s*>/i',
            ],
            "\n",
            $value
        ) ?? $value;
    }
}
