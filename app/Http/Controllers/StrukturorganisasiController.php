<?php

namespace App\Http\Controllers;

use App\Models\Struktur;
use Illuminate\Contracts\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class StrukturorganisasiController extends Controller
{
    public function index(): View
    {
        $seoTitle = 'Struktur Organisasi DISPUSAKA Sulawesi Tengah | Profil Instansi';

        $seoDescription = 'Lihat struktur organisasi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah, susunan kepemimpinan, unit kerja, pembagian fungsi, serta sistem koordinasi kelembagaan.';

        $seoUrl = url()->current();

        // Gambar SEO otomatis dari database
        $seoImage = (isset($struktur) && $struktur && $struktur->gambar)
            ? asset('uploads_files/profil/' . $struktur->gambar)
            : asset('assets/images/Logo-Sulteng.png');

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
            'Struktur Organisasi DISPUSAKA Sulawesi Tengah',
            'Struktur Organisasi DISPUSAKA Sulteng',
            'Bagan Organisasi DISPUSAKA',
            'Susunan Organisasi DISPUSAKA',
            'Kepemimpinan DISPUSAKA Sulawesi Tengah',
            'Unit Kerja DISPUSAKA',
            'Profil Organisasi DISPUSAKA',
            'Dinas Perpustakaan dan Kearsipan Sulteng',
            'Struktur Dinas Perpustakaan',
            'Struktur Dinas Kearsipan',
            'Pemerintah Provinsi Sulawesi Tengah'
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

        $struktur = Struktur::query()->first();
        return view('home.struktur', compact('struktur'));
    }
}
