<?php

namespace App\Http\Controllers;

use App\Models\Pamflet;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class PamfletController extends Controller
{
    // ==========================================
    // HELPER GAMBAR SEO
    // ==========================================

    private function getPamfletImageUrl($gambar): string
    {
        // Mendukung gambar dalam bentuk JSON string
        if (is_string($gambar)) {
            $decoded = json_decode($gambar, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $gambar = $decoded;
            } else {
                $gambar = [$gambar];
            }
        }

        // Ambil gambar pertama
        $filename = is_array($gambar)
            ? (array_values($gambar)[0] ?? null)
            : null;

        return !empty($filename)
            ? asset('uploads_files/pamflet/' . $filename)
            : asset('assets/images/Logo-Sulteng.png');
    }


    // ==========================================
    // HALAMAN DAFTAR PAMFLET
    // ==========================================

    public function index(): View
    {
        $pamflet = Pamflet::query()
            ->select([
                'id',
                'nm_pamflet',
                'slug_pamflet',
                'deskripsi',
                'gambar',
                'status_id',
            ])
            ->where('status_id', 1)
            ->orderByDesc('id')
            ->simplePaginate(9)
            ->withQueryString();


        // ==========================================
        // SEO DAFTAR PAMFLET
        // ==========================================

        $currentPage = (int) $pamflet->currentPage();

        $seoTitle = 'Pamflet Informasi DISPUSAKA Sulawesi Tengah | Informasi Publik';

        if ($currentPage > 1) {
            $seoTitle .= ' - Halaman ' . $currentPage;
        }

        $seoDescription = 'Temukan berbagai pamflet informasi resmi DISPUSAKA Provinsi Sulawesi Tengah mengenai layanan perpustakaan, literasi, kearsipan, kegiatan instansi, dan informasi publik.';

        $seoUrl = request()->url();

        if ($currentPage > 1) {
            $seoUrl .= '?page=' . $currentPage;
        }

        // Gambar pamflet pertama pada halaman aktif
        $firstPamflet = $pamflet->getCollection()->first();

        $seoImage = $this->getPamfletImageUrl(
            $firstPamflet?->gambar
        );


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
            'Pamflet DISPUSAKA Sulawesi Tengah',
            'Pamflet Informasi Sulteng',
            'Informasi DISPUSAKA',
            'Pamflet Perpustakaan Sulawesi Tengah',
            'Pamflet Kearsipan Sulteng',
            'Informasi Literasi Sulawesi Tengah',
            'Media Informasi Perpustakaan',
            'Informasi Pelayanan Publik Sulteng',
            'Dinas Perpustakaan dan Kearsipan Sulteng',
            'Informasi Pemerintah Provinsi Sulawesi Tengah'
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

        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::twitter()->setTitle($seoTitle);
        SEOTools::twitter()->setDescription($seoDescription);
        SEOTools::twitter()->setUrl($seoUrl);
        SEOTools::twitter()->setImage($seoImage);


        // ==========================================
        // JSON-LD
        // ==========================================

        SEOTools::jsonLd()->setType('CollectionPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);


        return view('home.pamflet.index', compact('pamflet'));
    }


    // ==========================================
    // HALAMAN DETAIL PAMFLET
    // ==========================================

    public function show(Pamflet $pamflet): View
    {
        // Jangan tampilkan pamflet nonaktif
        abort_unless((int) $pamflet->status_id === 1, 404);


        // ==========================================
        // SEO DETAIL PAMFLET
        // ==========================================

        $seoTitle = $pamflet->nm_pamflet
            . ' | Pamflet DISPUSAKA Sulawesi Tengah';

        // Ambil deskripsi dari database
        $plainDescription = trim(
            preg_replace(
                '/\s+/',
                ' ',
                html_entity_decode(
                    strip_tags((string) ($pamflet->deskripsi ?? '')),
                    ENT_QUOTES | ENT_HTML5,
                    'UTF-8'
                )
            )
        );

        $seoDescription = $plainDescription !== ''
            ? Str::limit($plainDescription, 155, '...')
            : 'Informasi resmi DISPUSAKA Provinsi Sulawesi Tengah mengenai '
            . $pamflet->nm_pamflet . '.';

        $seoUrl = request()->url();

        // Gambar utama pamflet
        $seoImage = $this->getPamfletImageUrl(
            $pamflet->gambar
        );


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
            $pamflet->nm_pamflet,
            'Pamflet DISPUSAKA',
            'Informasi DISPUSAKA Sulawesi Tengah',
            'Pamflet Informasi Sulteng',
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
            'article'
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

        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::twitter()->setTitle($seoTitle);
        SEOTools::twitter()->setDescription($seoDescription);
        SEOTools::twitter()->setUrl($seoUrl);
        SEOTools::twitter()->setImage($seoImage);


        // ==========================================
        // JSON-LD
        // ==========================================

        SEOTools::jsonLd()->setType('WebPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);


        return view('home.pamflet.show', compact('pamflet'));
    }
}
