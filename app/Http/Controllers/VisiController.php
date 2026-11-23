<?php

namespace App\Http\Controllers;

use App\Models\Visimisippid;
use Illuminate\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;

class VisiController extends Controller
{
    /**
     * Menampilkan halaman Visi dan Misi PPID.
     */
    public function index(): View
    {
        // ==========================================
        // AMBIL DATA VISI DAN MISI PPID
        // ==========================================

        $visimisi = Visimisippid::query()
            ->select([
                'visi',
                'misi',
                'updated_at',
            ])
            ->orderByDesc('updated_at')
            ->first();

        $visi = $this->toPlainText($visimisi?->visi);

        $misiItems = $this->toMissionItems($visimisi?->misi);


        // ==========================================
        // SEO VISI DAN MISI PPID DISPUSAKA
        // ==========================================

        $seoTitle = 'Visi dan Misi PPID DISPUSAKA Sulawesi Tengah | Informasi Publik';

        // Gabungkan visi dan beberapa poin misi
        $seoContent = collect([
            $visi,
            implode(' ', array_slice($misiItems, 0, 2)),
        ])
            ->filter()
            ->implode(' ');

        // Deskripsi SEO dinamis
        $seoDescription = trim($seoContent) !== ''
            ? Str::limit(trim($seoContent), 155, '...')
            : 'Informasi visi dan misi PPID DISPUSAKA Provinsi Sulawesi Tengah sebagai landasan penyelenggaraan keterbukaan informasi publik, transparansi, dan pelayanan informasi kepada masyarakat.';

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
            'Visi dan Misi PPID DISPUSAKA',
            'Visi Misi PPID Sulawesi Tengah',
            'Visi Misi DISPUSAKA Sulteng',
            'PPID DISPUSAKA Sulawesi Tengah',
            'Keterbukaan Informasi Publik',
            'Pelayanan Informasi Publik',
            'Transparansi Informasi Pemerintah',
            'Profil PPID Sulteng',
            'Informasi Publik Sulawesi Tengah',
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

        return view('home.ppid.visi', [
            'visimisi' => $visimisi,
            'visi' => $visi,
            'misiItems' => $misiItems,
        ]);
    }

    /**
     * Mengubah isi editor menjadi teks bersih.
     *
     * Mendukung data plain text maupun HTML sederhana
     * dari editor seperti CKEditor/TinyMCE.
     */
    private function toPlainText(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $value = $this->normalizeEditorBreaks($value);

        $text = html_entity_decode(
            strip_tags($value),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $text = preg_replace('/\s+/u', ' ', $text);

        if ($text === null) {
            return null;
        }

        $text = trim($text);

        return $text !== '' ? $text : null;
    }

    /**
     * Mengubah field misi menjadi array item.
     *
     * Contoh input:
     * 1. Memberikan pelayanan...
     * 2. Menyediakan informasi...
     *
     * Hasil:
     * [
     *     'Memberikan pelayanan...',
     *     'Menyediakan informasi...',
     * ]
     */
    private function toMissionItems(?string $value): array
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

                // Hilangkan bullet atau nomor lama.
                $line = preg_replace(
                    '/^\s*(?:[-•▪●*]+|\d+\s*[.)-])\s*/u',
                    '',
                    $line
                ) ?? $line;

                return trim($line);
            })
            ->filter(fn(string $line): bool => $line !== '')
            ->values()
            ->all();
    }

    /**
     * Menormalkan line break yang berasal dari WYSIWYG editor.
     */
    private function normalizeEditorBreaks(string $value): string
    {
        return preg_replace(
            [
                '/<\s*br\s*\/?\s*>/i',
                '/<\s*\/\s*p\s*>/i',
                '/<\s*\/\s*li\s*>/i',
            ],
            "\n",
            $value
        ) ?? $value;
    }
}
