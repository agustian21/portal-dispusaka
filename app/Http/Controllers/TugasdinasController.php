<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Contracts\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class TugasdinasController extends Controller
{
    public function index(): View
    {
        $seoTitle = 'Tugas dan Fungsi DISPUSAKA Sulawesi Tengah | Profil Instansi';

        // Ambil deskripsi dari konten database
        $rawSeoContent = isset($data)
            ? (string) ($data->tugas_fungsi ?? '')
            : '';

        $plainSeoContent = trim(
            preg_replace(
                '/\s+/',
                ' ',
                html_entity_decode(
                    strip_tags($rawSeoContent),
                    ENT_QUOTES | ENT_HTML5,
                    'UTF-8'
                )
            )
        );

        // Gunakan deskripsi dinamis atau fallback
        $seoDescription = $plainSeoContent !== ''
            ? \Illuminate\Support\Str::limit($plainSeoContent, 155, '...')
            : 'Informasi tugas, fungsi, kewenangan, dan mandat Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah dalam penyelenggaraan pelayanan publik.';

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
            'Tugas dan Fungsi DISPUSAKA Sulawesi Tengah',
            'Tugas DISPUSAKA Sulteng',
            'Fungsi DISPUSAKA Sulteng',
            'Tugas Dinas Perpustakaan dan Kearsipan',
            'Fungsi Dinas Perpustakaan dan Kearsipan',
            'Kewenangan DISPUSAKA',
            'Mandat organisasi DISPUSAKA',
            'Profil DISPUSAKA Sulawesi Tengah',
            'Pelayanan perpustakaan Sulawesi Tengah',
            'Pelayanan kearsipan Sulawesi Tengah',
            'Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah'
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
        // JSON-LD STRUCTURED DATA
        // ==========================================

        SEOTools::jsonLd()->setType('WebPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);

        $data = Tugas::query()->first();
        return view('home.tugasdinas', compact('data'));
    }
}
